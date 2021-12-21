<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FiscalYear;
use App\Configure;
use App\IncomeExpenseTopic;
use App\IncomeExpense;
use Auth;
use Response;

class ConfigureController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        // $this->validate($request, [
        //     'name' => 'required|numeric',
        //     'start_date' => 'required',
        //     'end_date' => 'required',
        // ]);


        if($request['income_bill'] == true)
        {
            $income_bill = '1'; 
            // $incometopic =  IncomeExpenseTopic::create([
            //    'name' => 'Bill',
            //    'type' => '1',
            //    'slug' => strtolower('Bill'),
            //    'is_active' => '1',
            //    'date' => date("Y-m-d"),
            //    'date_np' => $this->helper->date_np_con(),
            //    'time' => date("H:i:s"),
            //    'created_by' => Auth::user()->id,
            // ]);

            // $incomeexpense = IncomeExpense::create([
            //    'topic_id' => $incometopic->id,
            //    'description' => 'Bill details',
            //    'amount' => '0',
            //    'iedate' => $this->helper->date_np_con(),
            //    'type' => '1',
            //    'is_active' => '1',
            //    'date' => date("Y-m-d"),
            //    'date_np' => $this->helper->date_np_con(),
            //    'time' => date("H:i:s"),
            //    'created_by' => Auth::user()->id,
            // ]);

        }
        else{
            $income_bill = '0';
        }


        if($request['expense_asset'] == true)
        {
            $expense_asset = '1'; 
            // $expensetopic =  IncomeExpenseTopic::create([
            //    'name' => 'Asset',
            //    'type' => '2',
            //    'slug' => strtolower('asset'),
            //    'is_active' => '1',
            //    'date' => date("Y-m-d"),
            //    'date_np' => $this->helper->date_np_con(),
            //    'time' => date("H:i:s"),
            //    'created_by' => Auth::user()->id,
            // ]);

            // $incomeexpense = IncomeExpense::create([
            //    'topic_id' => $expensetopic->id,
            //    'description' => 'Asset details',
            //    'amount' => '0',
            //    'iedate' => $this->helper->date_np_con(),
            //    'type' => '2',
            //    'is_active' => '1',
            //    'date' => date("Y-m-d"),
            //    'date_np' => $this->helper->date_np_con(),
            //    'time' => date("H:i:s"),
            //    'created_by' => Auth::user()->id,
            // ]);

        }
        else{
            $expense_asset = '0';
        }

        if($request['income_receiveamount'] == true)
        {
            $income_receiveamount = '1'; 
        }
        else{
            $income_receiveamount = '0';
        }
        if($request['expense_ispaid'] == true)
        {
            $expense_ispaid = '1'; 
        }
        else{
            $expense_ispaid = '0';
        }
        Configure::create([
            'income_bill' => $income_bill,
            'income_receiveamount' => $income_receiveamount,
            'expense_asset' => $expense_asset,
            'expense_ispaid' => $expense_ispaid,
            'date' => date("Y-m-d"),
            'date_np' => $this->helper->date_np_con(),
            'time' => date("H:i:s"),
            'is_active' => '1',
            'created_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Created'];
    }
}
