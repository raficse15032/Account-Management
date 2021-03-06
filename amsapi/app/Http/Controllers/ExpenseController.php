<?php

namespace App\Http\Controllers;

use App\Models\MoneyOut\Expense;
use Illuminate\Http\Request;
use App\RoleUser;
use Sentinel;

use App\Http\Resources\Expense as ExpenseResource;

class ExpenseController extends Controller
{
    public function index(Request $request){

        $vendor = ($request->has('vendor'))?$request['vendor']:null;
        $purpose = ($request->has('purpose'))?$request['purpose']:null;

        $user_id = Auth()->user()->id;
        $role_id = RoleUser::where('user_id',$user_id)->first()->role_id;
        $role = Sentinel::findRoleById($role_id);

        if ($role->hasAccess(['expense.view'])){
            $expense  = Expense::when($vendor, function($q) use($vendor,$user_id){return $q->where('created_by',$user_id)->where('vendor_id',$vendor);})
                ->when($purpose, function($q) use($purpose,$user_id){return $q->where('created_by',$user_id)->where('account_id',$purpose);})
                ->when($user_id , function($q) use($user_id){return $q->where('created_by',$user_id);})
                ->paginate(10);
        }

        if ($role->hasAccess(['expense.viewall'])){
            $expense  = Expense::when($purpose, function($q) use($purpose){return $q->where('account_id',$purpose);})
                      ->when($vendor, function($q) use($vendor){return $q->where('vendor_id',$vendor);})
                     ->paginate(10);

        }
        
        return ExpenseResource::collection($expense);

    }

    public function store(Request $request)
    {

        $expense = $request->isMethod('put') ? Expense::findOrFail($request->expense_id) : new Expense;
        $expense -> date = $request->input('date');
        $expense -> amount = $request->input('amount');
        $expense -> tax_total = $request->input('tax_total');
        $expense -> reference = $request->input('reference');
        $expense -> note = $request->input('note');
        $expense -> account_id = $request->input('account_id');
        $expense -> vendor_id = $request->input('vendor_id');
        $expense -> bank_info = $request->input('bank_info');

        $log_user = Auth()->user();
        $request->isMethod('put') ?  $expense->updated_by = $log_user->id : '' ;
        $request->isMethod('post') ? $expense->created_by = $log_user->id : '' ;
        $request->isMethod('post') ? $expense->updated_by = $log_user->id : '' ;

        if($expense->save()){
            return new ExpenseResource($expense);
        }
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);

        if($expense->delete()){
            return new ExpenseResource($expense);
        }
    }
}