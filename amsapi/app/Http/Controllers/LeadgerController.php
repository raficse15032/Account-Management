<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MoneyIn\Income;
use App\Http\Resources\GeneralLeadger as GeneralLeadgerResource;
use DB;
use Carbon\Carbon;
class LeadgerController extends Controller
{
    public function currentLeadger(){
    	$filterIncomeExpense = '';
    	$current_month = date('m');

    	$incomes = DB::select( DB::raw("SELECT *, ifnull(amount, 0) + ifnull(utility, 0)+ ifnull(car_parking, 0)+ ifnull(registration_cost, 0)+ ifnull(other_cost, 0) - ifnull(gift, 0) - ifnull(discount, 0)  as total, 1 as type  FROM incomes WHERE MONTH(date) = '$current_month' ") );

        $expenses = DB::select( DB::raw("SELECT *,ifnull(amount, 0) + ifnull(tax_total, 0) as total, 2 as type FROM expenses WHERE MONTH(date) = '$current_month'") );

        $payments = DB::select( DB::raw("SELECT *, amount as total, 1 as type  FROM  payment_receives WHERE MONTH(date) = '$current_month' ") );

        $invoices = DB::select( DB::raw("SELECT *, total as total, 3 as type  FROM   invoices WHERE MONTH(date) = '$current_month' ") );



    	// $expenses = DB::select( DB::raw("SELECT *,ifnull(amount, 0) + ifnull(tax_total, 0) as total, 2 as type FROM expenses WHERE MONTH(date) = '$current_month' ") );

    	$filterIncomeExpense = array_merge($expenses,$incomes,$invoices,$payments);
        
    	$newFilterIncomeExpense = [];
    	foreach ($filterIncomeExpense as $key => $value) {

    		if( isset($value->customer_id) ? $value->customer_id : false){
    			$customer = DB::select( DB::raw("SELECT name FROM users WHERE id = '$value->customer_id' "));
    		}
    		else{
    			$customer = '';
    		}
    		if( isset($value->vendor_id) ? $value->vendor_id : false){
    			$vendor = DB::select( DB::raw("SELECT name FROM users WHERE id = '$value->vendor_id' "));
    		}
    		else{
    			$vendor = '';
    		}

            if( isset($value->invoice_number) ? $value->invoice_number : false){
                $invoice_number = $value->invoice_number;
            }
            else{
                $invoice_number = '';
            }
            

            if( isset($value->pr_number) ? $value->pr_number : false){
                $pr_number = $value->pr_number;
            }
            else{
                $pr_number = '';
            }

    		$account = DB::select( DB::raw("SELECT name FROM accounts WHERE id = '$value->account_id' "));
    		$data = array('date' => $value->date,'total' => $value->total,'type'=>$value->type,'customer'=> $customer,'vendor'=> $vendor,'account'=>$account,'invoice_number'=>$invoice_number,'pr_number'=>$pr_number);
    		array_push($newFilterIncomeExpense,$data);
    	}

        
        // return response()->json(['error'=>$newFilterIncomeExpense],401);

    	return $newFilterIncomeExpense;

    }

    public function searchLeadger(Request $request){
        //return $request->all();
    	$filterIncomeExpense = '';

    	$vendor_id = $request->vandor_id;
    	$account_id = $request->account_id;
    	$customer_id = $request->customer_id;
    	$strat_date = $request->strat_date;
    	$end_date = $request->end_date;
    	if($strat_date != '' && $end_date == '')
    	{
    		return '';
    	}

    	$incomes = DB::select( DB::raw("SELECT *, ifnull(amount, 0) + ifnull(utility, 0)+ ifnull(car_parking, 0)+ ifnull(registration_cost, 0)+ ifnull(other_cost, 0) - ifnull(gift, 0) - ifnull(discount, 0)  as total, 1 as type  FROM incomes WHERE date between '$strat_date' and '$end_date' or account_id = '$account_id' or customer_id = '$customer_id'") );
    	$expenses = DB::select( DB::raw("SELECT *,ifnull(amount, 0) + ifnull(tax_total, 0) as total, 2 as type FROM expenses WHERE date between '$strat_date' and '$end_date' or account_id = '$account_id' or vendor_id = '$vendor_id'") );

    	// return $results = DB::select( DB::raw("SELECT * FROM incomes WHERE date between '2012-03-11' and '2019-05-11' ") );

    	 $filterIncomeExpense = array_merge($expenses,$incomes);
    	$newFilterIncomeExpense = [];
    	foreach ($filterIncomeExpense as $key => $value) {

    		if( isset($value->customer_id) ? $value->customer_id : false){
    			$customer = DB::select( DB::raw("SELECT name FROM users WHERE id = '$value->customer_id' "));
    		}
    		else{
    			$customer = '';
    		}
    		if( isset($value->vendor_id) ? $value->vendor_id : false){
    			$vendor = DB::select( DB::raw("SELECT name FROM users WHERE id = '$value->vendor_id' "));
    		}
    		else{
    			$vendor = '';
    		}

    		$account = DB::select( DB::raw("SELECT name FROM accounts WHERE id = '$value->account_id' "));
    		$data = $arrayName = array('date' => $value->date,'total' => $value->total,'type'=>$value->type,'customer'=> $customer,'vendor'=> $vendor,'account'=>$account);
    		array_push($newFilterIncomeExpense,$data);
    	}


    	return $newFilterIncomeExpense;

    }
    public function dashboardLeadger(Request $request){

        $filterIncomeExpense = '';

        $vendor_id = $request->vandor_id;
        $account_id = $request->account_id;
        $customer_id = $request->customer_id;
        $strat_date = Carbon::now()->format('Y-m-d');
        $end_date = Carbon::now()->format('Y-m-d');
        if($strat_date != '' && $end_date == '')
        {
            return '';
        }

        $incomes = DB::select( DB::raw("SELECT *, ifnull(amount, 0) + ifnull(utility, 0)+ ifnull(car_parking, 0)+ ifnull(registration_cost, 0)+ ifnull(other_cost, 0) - ifnull(gift, 0) - ifnull(discount, 0)  as total, 1 as type  FROM incomes WHERE date between '$strat_date' and '$end_date' or account_id = '$account_id' or customer_id = '$customer_id'") );
        $expenses = DB::select( DB::raw("SELECT *,ifnull(amount, 0) + ifnull(tax_total, 0) as total, 2 as type FROM expenses WHERE date between '$strat_date' and '$end_date' or account_id = '$account_id' or vendor_id = '$vendor_id'") );

        // return $results = DB::select( DB::raw("SELECT * FROM incomes WHERE date between '2012-03-11' and '2019-05-11' ") );

         $filterIncomeExpense = array_merge($expenses,$incomes);
        $newFilterIncomeExpense = [];
        foreach ($filterIncomeExpense as $key => $value) {

            if( isset($value->customer_id) ? $value->customer_id : false){
                $customer = DB::select( DB::raw("SELECT name FROM users WHERE id = '$value->customer_id' "));
            }
            else{
                $customer = '';
            }
            if( isset($value->vendor_id) ? $value->vendor_id : false){
                $vendor = DB::select( DB::raw("SELECT name FROM users WHERE id = '$value->vendor_id' "));
            }
            else{
                $vendor = '';
            }

            $account = DB::select( DB::raw("SELECT name FROM accounts WHERE id = '$value->account_id' "));
            $data = $arrayName = array('date' => $value->date,'total' => $value->total,'type'=>$value->type,'customer'=> $customer,'vendor'=> $vendor,'account'=>$account);
            array_push($newFilterIncomeExpense,$data);
        }

        return $newFilterIncomeExpense;

    }
}


// select ifnull(item_1, 0) + ifnull(item_2, 0) + ifnull(item_3, 0) + ifnull(item_4, 0) as ItemSum
// from MyTable

