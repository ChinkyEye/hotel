<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Table;
use App\Item;
use App\Order;
use App\Order_detail;
use Auth;

class OrderController extends Controller
{
    public function show($id){
      $posts = Item::with('unit')->find($id);
        return response()->json([
            'posts'=>$posts
        ],200);
    }

    public function store(Request $request)
    {   
        $bill_id = strtotime(date(("Y-m-d H:i:s")));
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $auth = Auth::user()->id;

        $calc_gtotal = 0;
        $cal_discount = 0;
        $req_disc = 0;
        $req_total = 0;
        $loop_check = $request->data;
        foreach ($loop_check as $key => $value) {
            // var_dump($value['quantity']); die();
            $calc_value = Item::where('id', $value['id'])->get();
            foreach ($calc_value as $index => $calc_values) {
                $calc_item_id = $calc_values->id;
                $calc_unit_id = $calc_values->unit_id;
                $calc_rate = $calc_values->price;
                $calc_cat_id = $calc_values->category_id;
                $calc_mg = 0;
                $calc_weight = 0;
                $calc_discount = 0;
            }
            $order = New Order();
            $order->customer_id = $request->user_id;
            $order->usertype_id = $request->user_t_id;
            $order->bill_id = $bill_id;
            $order->item_id = $calc_item_id;
            $order->category_id = $calc_cat_id;
            $order->unit_id = $calc_unit_id;
            $order->quantity = $value['quantity'];
            $ca_discount = $value['quantity']*($calc_discount);
            $cal_tot = $value['quantity']*($calc_rate - $calc_discount);
            $order->total = $cal_tot;
            $order->date = $current_date;
            $order->date_np = $this->helper->date_np_con();
            $order->time = $current_time;
            $order->is_confirmed = '0';
            $order->bill_type = '0';
            $order->created_by = $auth;
            $order->save();
        // $calc_gtotal += $cal_tot;
        // $cal_discount += $ca_discount;
        }
        // $req_disc = $cal_discount + $request->mdiscount;
        // $req_total = $calc_gtotal - $request->mdiscount;
        $order_total = new Order_detail;
        $order_total->bill_id = $bill_id;
        $order_total->total = '0';
        $order_total->discount = '0';
        $order_total->grand_total = '0';
        $order_total->customer_id = $request->user_id;
        $order_total->table_id = $request->table_id;
        $order_total->usertype_id = $request->user_t_id;
        $order_total->date = $current_date;
        $order_total->date_np = $this->helper->date_np_con();
        $order_total->time = $current_time;
        $order_total->received = '0';
        $order_total->is_active = '1';
        $order_total->is_confirmed = '0';
        $order_total->bill_type = '0';
        $order_total->created_by = $auth;
        $order_total->save();
        
        return response()->json([
            'message'=>'ok',
            'bill_id' => $bill_id
        ],200);
    }

    public function bill($bill){
        $bills = Order_detail::where('bill_id', $bill)->with('order','customer')->first();
        return response()->json([
            'bills'=>$bills
        ],200);
    }
}