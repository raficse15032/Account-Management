<?php

namespace App\Http\Controllers;

use App\Models\MoneyIn\Income;
use Illuminate\Http\Request;
use Sentinel;
use App\RoleUser;
use App\Http\Resources\Income as IncomeResource;

class IncomeController extends Controller
{
    public function index(Request $request){
        $agent = ($request->has('agent'))?$request['agent']:null;
        $customer = ($request->has('customer'))?$request['customer']:null;
        $purpose = ($request->has('purpose'))?$request['purpose']:null;

        $user_id = Auth()->user()->id;
        $role_id = RoleUser::where('user_id',$user_id)->first()->role_id;
        $role = Sentinel::findRoleById($role_id);
        $income = '';
        if ($role->hasAccess(['income.view'])){
            $income  = Income::when($agent || $customer || $purpose, function($q) use($agent,$customer,$purpose,$user_id){return $q->when('created_by',$user_id)->where('agent_id',$agent)->orWhere('customer_id',$customer)->orWhere('account_id',$purpose);})
                ->when($user_id , function($q) use($user_id){return $q->where('created_by',$user_id);})
                ->paginate(10);
        }
        if ($role->hasAccess(['income.viewall'])){
            $income  = Income::when($agent || $customer || $purpose, function($q) use($agent,$customer,$purpose){return $q->where('agent_id',$agent)->orWhere('customer_id',$customer)->orWhere('account_id',$purpose);})
                ->paginate(10);
        }

         
        return IncomeResource::collection($income);
    }

    public function store(Request $request)
    {

        $income = $request->isMethod('put') ? Income::findOrFail($request->income_id) : new Income;
        $income -> date = $request->input('date');
        $income -> amount = $request->input('amount');
        $income -> discount = $request->input('discount');
        $income -> utility = $request->input('utility');
        $income -> car_parking = $request->input('car_parking');
        $income -> registration_cost = $request->input('registration_cost');
        // $income -> tax_total = $request->input('tax_total');
        $income -> other_cost = $request->input('other_cost');
        $income -> gift = $request->input('gift');
        $income -> reference = $request->input('reference');
        $income -> note = $request->input('note');
        $income -> account_id = $request->input('account_id');
        $income -> agent_id = $request->input('agent_id');
        $income -> customer_id = $request->input('customer_id');
        $income -> bank_info = $request->input('bank_info');

        $log_user = Auth()->user();
        $request->isMethod('put') ?  $income ->updated_by = $log_user->id : '' ;
        $request->isMethod('post') ? $income ->created_by = $log_user->id : '' ;
        $request->isMethod('post') ? $income ->updated_by = $log_user->id : '' ;

        
        if($income->save()){
            return new IncomeResource($income);
        }
    }

    public function destroy($id)
    {
        $income = Income::findOrFail($id);

        if($income->delete()){
            return new IncomeResource($income);
        }
    }
}


            
