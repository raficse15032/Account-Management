<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Models\Recruiting\Visa;
use App\Models\MoneyOut\Expense;
use App\Models\MoneyIn\Income;
use App\User;
class StatisticsController extends Controller
{
    public function index(){
    	$visa = Visa::count();
    	$expense = Expense::count();
    	$income = Income::count();
    	$user = User::count();

    	$data = [
            'visa'    => $visa,
            'expense' => $expense,
            'income'  => $income,
            'profit'  => $income-$expense,
            'user'  => $user,
        ];
        return Response::Json($data); 
    }
}
