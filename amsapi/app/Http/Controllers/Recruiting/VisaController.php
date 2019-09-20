<?php

namespace App\Http\Controllers\Recruiting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Recruiting\Visa as VisaResource;
use App\Models\Recruiting\Visa;
use App\Models\MoneyIn\Invoice;
use Auth;
class VisaController extends Controller
{
    public function index(Request $request){
        //return $request->all();
      $diving_licence_status     = ($request->has('diving_licence_status'))?$request['diving_licence_status']:null;
      $type     = ($request->has('type'))?$request['type']:null;
      $police_clearence_status     = ($request->has('police_clearence_status'))?$request['police_clearence_status']:null;
      $medical_status     = ($request->has('medical_status'))?$request['medical_status']:null;
      $musaned_status     = ($request->has('musaned_status'))?$request['musaned_status']:null;
      $okala_status     = ($request->has('okala_status'))?$request['okala_status']:null;
      $mofa_status     = ($request->has('mofa_status'))?$request['mofa_status']:null;
      $stamping_status     = ($request->has('stamping_status'))?$request['stamping_status']:null;
      $finger_training_status     = ($request->has('finger_training_status'))?$request['finger_training_status']:null;
      $manpower_status     = ($request->has('manpower_status'))?$request['manpower_status']:null;
      $flight_status     = ($request->has('flight_status'))?$request['flight_status']:null;
      $account_status     = ($request->has('account_status'))?$request['account_status']:null;
        $limit     = ($request->has('limit'))?$request['limit']:10;
      $search     = ($request->has('search'))?$request['search']:null;
      $visa = Visa::when($diving_licence_status, function($q) use($diving_licence_status){return $q->where('diving_licence_status', $diving_licence_status);})
          ->when($police_clearence_status, function($q) use($police_clearence_status){return $q->where('police_clearence_status', $police_clearence_status);})
          ->when($medical_status, function($q) use($medical_status){return $q->where('medical_status', $medical_status);})
          ->when($musaned_status, function($q) use($musaned_status){return $q->where('musaned_status', $musaned_status);})
          ->when($okala_status, function($q) use($okala_status){return $q->where('okala_status', $okala_status);})
          ->when($mofa_status, function($q) use($mofa_status){return $q->where('mofa_status', $mofa_status);})
          ->when($stamping_status, function($q) use($stamping_status){return $q->where('stamping_status', $stamping_status);})
          ->when($finger_training_status, function($q) use($finger_training_status){return $q->where('finger_training_status', $finger_training_status);})
          ->when($manpower_status, function($q) use($manpower_status){return $q->where('manpower_status', $manpower_status);})
          ->when($flight_status, function($q) use($flight_status){return $q->where('flight_status', $flight_status);})
          ->when($account_status, function($q) use($account_status){return $q->where('account_status', $account_status);})
          ->when($type, function($q) use($type){return $q->where('type', $type);})
                ->when($search, function($q) use($search){return $q->where('passport_number','like',"%$search%")->OrWhere('visa_number','like',"%$search%")->OrWhere('worker_number','like',"%$search%");})
          ->paginate($limit);
        return VisaResource::collection($visa);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'visa_number'          => 'required',
            'user_id'              =>'required',
            //'agent_id'             =>'required',
            'passport_number'      => 'required',
            'passport_name'        => 'required',
            'type'                 => 'required',
        ]);
        //$user = Auth::user();
        $user_id = Auth()->user()->id;
       
        $visa = $request->input('id')!=null ? Visa::findOrfail($request->id) : new Visa();
        $visa->passport_name = $request->input('passport_name');
        $visa->passport_number = $request->input('passport_number');
        $visa->visa_number = $request->input('visa_number');
        $visa->processing_rate = $request->input('processing_rate');
        $visa->company_id_number = $request->input('company_id_number');
        $visa->occupation = $request->input('occupation');
        $visa->gender = $request->input('gender');
        
        $visa->diving_licence_by = $user_id;
        $visa->diving_licence_status = $request->input('diving_licence_status');
       
        $visa->police_clearence_by = $user_id;
        $visa->police_clearence_status = $request->input('police_clearence_status');
       
        
        if($request->input('entryType')==3){
           $visa->medical_by = $user_id;
           $visa->medical_status = $request->input('medical_status');
           $visa->medical = $request->input('medical');
        }
        
        if($request->input('musaned_status')==4){
           $visa->musaned_date_by = $user_id;
           $visa->musaned_status = $request->input('musaned_status');
           $visa->musaned_date = $request->input('musaned_date');
        }
        
        if($request->input('entryType')==5){
           $visa->okala_date_by = $user_id;
           $visa->okala_status = $request->input('okala_status');
           $visa->okala_date = $request->input('okala_date');
        }
        
        
        if($request->input('entryType')==6){
           $visa->mofa_date_by = $user_id;
           $visa->mofa_status = $request->input('mofa_status');
           $visa->mofa_date = $request->input('mofa_date');
        }
       
        
        if($request->input('entryType')==7){
           $visa->stamping_by = $user_id;
           $visa->stamping_status = $request->input('stamping_status');
           $visa->stamping_date = $request->input('stamping_date');
        }
        
        if($request->input('entryType')==8){
           $visa->finger_training_by = $user_id;
           $visa->finger_training_status = $request->input('finger_training_status');
           $visa->finger_training_date = $request->input('finger_training_date');
        }
        if($request->input('entryType')==9){
           $visa->manpowe_date_by = $user_id;
           $visa->manpower_status = $request->input('manpower_status');
           $visa->manpowe_date = $request->input('manpowe_date');
        }
        
        if($request->input('entryType')==10){
           $visa->flight_date_by = $user_id;
           $visa->flight_status = $request->input('flight_status');
           $visa->flight_date = $request->input('flight_date');
        }
        
        if($request->input('entryType')==11){
           $visa->account_date_by = $user_id;
           $visa->account_status = $request->input('account_status');
           $visa->account_date = $request->input('account_date');
        }
        $visa->agent_id = $request->input('agent_id');
        $visa->user_id = $request->input('user_id');
        if($request->input('id')==null){
          $visa->created_by = $user_id;
          $visa->worker_number = $request->input('worker_number');
        }
        $visa->updated_by = $user_id;
        $visa->type = $request->input('type');
        $visa->save();
        if($request->input('id')==null){
            $invoice = new Invoice();
            $invoice -> date = $visa->created_at;
            $invoice -> customer_id = $request->input('user_id');
            $invoice -> visa_id = $visa->id;
            $invoice -> agent_id = $request->input('agent_id');
            $invoice -> account_id = 1;
            $invoice -> total = $request->input('processing_rate');
            $invoice -> due_amount = $request->input('processing_rate');
            $invoice -> invoice_number = "INV-".time();
            $invoice ->created_by = $user_id;
            $invoice ->updated_by = $user_id;
            $invoice->save();
        }
            
        return new VisaResource($visa);

    }
    public function  delete($id){
        $visa = Visa::find($id);
        if($visa){
            if($visa->delete()){
                return new VisaResource($visa); 
            }
        }
    }
    
    public function  getlastid(){
        $lastid = Visa::orderBy('id','DESC')->first();
        if($lastid){
            return $lastid->id+1;
        }else{
           return 1; 
        }
    }
    
    public function customerVisa($id){
        $visa = Visa::where('user_id',$id)->get();
        return VisaResource::collection($visa);
    }
}
