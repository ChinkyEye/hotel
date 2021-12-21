<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Pre_order;
use App\Order_detail;
use App\Order;


class OrderController extends Controller
{
    //
 public function store_order(Request $request) {
        $bill_id = strtotime(date(("Y-m-d H:i:s")));
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $auth = Auth::user()->id;

        $calc_total='0';

        $table_id= $request->table_id;

        $mycarts = Pre_order::where('table_id',$table_id)->get();

        foreach ($mycarts as $key => $value) {
          
            $order = New Order();
            $order->customer_id = '3';
            $order->usertype_id = '7'; // eslae paxi 8 banaune for physical customer aile demo ko lagi 2 banako
            $order->bill_id = $bill_id;
            $order->item_id = $value->item_id;
            $order->category_id = $value->getItems->category_id;
            $order->unit_id = $value->getItems->unit_id;
            $order->quantity = $value->quantity;
            $order->total = $value->getItems->price*$value['quantity'];
            $order->is_confirmed = '0';
            $order->bill_type = '0';
            $order->item_type_id = $value->getItems->item_type_id;
            $order->status = '1';
            $order->is_active = '1';
            $order->created_by = $auth;
           $order->billed_by  = $auth;
            $order->date_np = $this->helper->date_np_con();
            $order->date = $current_date;
            $order->time = $current_time;
             $order->save();

           // $calc_total += $value->getItems->price*$value['quantity'];
        }
        // $req_disc = $cal_discount + $request->mdiscount;
        // $req_total = $calc_gtotal - $request->mdiscount;
        $order_total = new Order_detail;
        $order_total->bill_id = $bill_id;
        $order_total->total = $calc_total;
        $order_total->discount = '0';
        $order_total->grand_total = '0';
        $order_total->received = '0';
        $order_total->customer_id = '3';
        $order_total->usertype_id = '7'; 
        $order_total->table_id = $table_id;
        $order_total->is_active = '1';
        $order_total->is_confirmed = '0';
        $order_total->bill_type = '0';
        $order_total->receive_type = '0';
        $order_total->created_by = $auth;
       $order_total->billed_by  = $auth;
        $order_total->date_np = $this->helper->date_np_con();
        $order_total->date = $current_date;
        $order_total->time = $current_time;
         $order_total->save();

        Pre_order::where('table_id', $table_id)->delete();
        
        return response()->json([[
            'message'=>'ok',
            'bill_id' => $bill_id
        ]],200);
  }  



//get order according to table 
   public function get_tablewise_Order(Request $request){
        $items = Order::orderBy('id','DESC')
                ->where('bill_id',$request['bill_id'])
                ->with('item.getunit')
                ->get();
         return response()->json($items);

    }

//get waiters log according to today's date from order_detail table
     public function get_waiter_log(){
        $current_date = date("Y-m-d");
        $auth = Auth::user()->id;
        
        $log = Order_detail::orderBy('id','DESC')
                ->where('date',$current_date)
                ->where('created_by',$auth)
                  ->with('customer')
                  ->with('table')
                  ->get();
         return response()->json($log);

    }

    //get waiters log according to today's date from order table
     public function get_waiter_log_details(Request $request){
        $auth = Auth::user()->id;
        
        $log_details = Order::orderBy('id','DESC')
                ->where('created_by',$auth)
                ->where('bill_id',$request['bill_id'])
                 ->with('item.getunit')
                  ->get();
         return response()->json($log_details);

    }
    
}
