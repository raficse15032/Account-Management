<?php

namespace App\Http\Controllers;

use App\Models\MoneyIn\PaymentReceive;
use Illuminate\Http\Request;
use App\Models\MoneyIn\Invoice;
use Sentinel;
use App\RoleUser;
use App\Http\Resources\Invoice as InvoiceResource;
use App\Http\Resources\PaymentReceive as PaymentReceiveResource;
class PaymentReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
      $limit     = ($request->has('limit'))?$request['limit']:10;
      $customer_id     = ($request->has('customer_id'))?$request['customer_id']:null;
      $PaymentReceive = PaymentReceive::when($customer_id, function($q) use($customer_id){return $q->where('customer_id',$customer_id);})
          ->paginate($limit);
        return PaymentReceiveResource::collection($PaymentReceive);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paymentReceive = $request->isMethod('put') ? PaymentReceive::findOrFail($request->payment_id) : new PaymentReceive;
        // return response()->json(['value'=>$paymentReceive],401);
        $paymentReceive -> date = $request->input('date');
        $paymentReceive -> customer_id = $request->input('customer_id');
        $paymentReceive -> payment_mode_id = $request->input('payment_mode_id');
        $paymentReceive -> amount = $request->input('amount');
        $paymentReceive -> reference = $request->input('reference');
        $paymentReceive -> customer_note = $request->input('customer_note');
        $request -> isMethod('post') ? $paymentReceive-> pr_number = "PRN-".time() : '' ;
        $paymentReceive -> invoices = json_encode($request->input('invoices'));
        $paymentReceive -> account_id = 7;
        
        if($request->isMethod('post')){
            foreach ($request->input('invoices') as $key => $value){
                $invoice =  Invoice::find($value['invoice_id']);
                $due_amount = $invoice->due_amount-$value['amount'];
                if($due_amount>=0){
                    $invoice->due_amount = $due_amount;
                }else{
                    $invoice->due_amount=0;
                }
                $invoice->save();  
            }
        }
        if($request->isMethod('put')){
            $old_invoices = json_decode(PaymentReceive::where('id',$request->payment_id)->first()->invoices);
            foreach ($request->input('invoices') as $key => $value){
                $invoice =  Invoice::find($value['invoice_id']);
                foreach ($old_invoices as $old_invoice) {
                    if($old_invoice->invoice_id == $invoice->id ){
                        $due_amount = $invoice->due_amount-$value['amount'];
                        $due_amount = floatval($due_amount) + floatval($old_invoice->amount);
                    }
                    else{
                        $due_amount = $invoice->due_amount-$value['amount'];
                    }
                }
                if($due_amount>=0){
                    $invoice->due_amount = $due_amount;
                }else{
                    $invoice->due_amount=0;
                }
                $invoice->save();  
            }
        }

        $log_user = Auth()->user();
        $request->isMethod('put') ?  $paymentReceive ->updated_by = $log_user->id : '' ;
        $request->isMethod('post') ? $paymentReceive ->created_by = $log_user->id : '' ;
        $request->isMethod('post') ? $paymentReceive ->updated_by = $log_user->id : '' ;


        if($paymentReceive->save()){
            return new PaymentReceiveResource($paymentReceive);
        }
    }


   
    public function destroy($id)
    {
        $payment_receive = PaymentReceive::find($id);
        return response()->json(['error'=>"'$payment_receive'"],401);
        foreach (json_decode($payment_receive->invoices) as $invo){
            $invoice =  Invoice::find($invo->invoice_id);
            $invoice->due_amount = $invoice->due_amount + $invo->amount;
            $invoice->save();
        }
        if($payment_receive->delete()){
            return new PaymentReceiveResource($payment_receive);
        }
    }
}
