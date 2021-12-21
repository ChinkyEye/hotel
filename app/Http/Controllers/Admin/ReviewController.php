<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Table;
use App\Item;
use App\Order;
use App\Order_detail;
use Auth;

class ReviewController extends Controller
{
    public function index(Request $request){
    $posts = Order_detail::orderBy('id','DESC');
    if(!empty($request->search))
        {            
            $posts = $posts->where('bill_id', 'LIKE',"%{$request->search}%");
        }
    if(!empty($request->user_type))
      {
        $posts = $posts->where('usertype_id','LIKE',"%{$request->user_type}%");
      }
    if(!empty($request->table_id))
      {
        $posts = $posts->where('table_id',$request->table_id);
      }
    if(!empty($request->date))
      {
        $posts = $posts->where('date', $request->date);
      }
        $posts = $posts->with('customer','usertype','table')->withCount('count')->where('is_confirmed','0')->where('is_active','1')->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'orderreviewdetails' => $posts
       ];
       return response()->json($response);
    }

    public function show($id){
        $notconfirmbills = Order_detail::where('id', $id)->with('orderstatus','customer','table')->first();
        return response()->json([
            'reviewbills'=>$notconfirmbills
        ],200);
    }

    public function store(Request $request)
    {   
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $auth = Auth::user()->id;

        $calc_gtotal = 0;
        $cal_discount = 0;
        $req_disc = 0;
        $req_total = 0;
        $loop_check = $request->data;
        foreach ($loop_check as $key => $value) {
            $calc_value = Item::where('id', $value['item_id'])->get();
            $bill_id = $request->bill_id;
            foreach ($calc_value as $index => $calc_values) {
                $calc_item_id = $calc_values->id;
                $calc_unit_id = $calc_values->unit_id;
                $calc_item_type_id = $calc_values->item_type_id;
                $calc_rate = $calc_values->price;
                $calc_cat_id = $calc_values->category_id;
                $calc_mg = 0;
                $calc_weight = 0;
                $calc_discount = 0;
            $update_count = Order::where('bill_id', $bill_id)->where('item_id', $value['item_id'])->count();
                if($update_count){
                    $order_id = Order::where('bill_id', $bill_id)->where('item_id', $value['item_id'])->value('id');
                    $orderupdate = Order::find($order_id);
                    $orderupdate->quantity = $value['quantity'];
                    // $ca_discount = $value['quantity']*($calc_discount);
                    $cal_tot = $value['quantity']*($calc_rate - $calc_discount);
                    $orderupdate->total = $cal_tot;
                    $orderupdate->date = $current_date;
                    $orderupdate->date_np = $this->helper->date_np_con();
                    $orderupdate->time = $current_time;
                    $orderupdate->is_confirmed = '0';
                    $orderupdate->status = '0';
                    $orderupdate->save();
                }
                else{
                    $order = new Order();
                    $cid = Order::where('bill_id', $bill_id)->value('customer_id');
                    $uid = Order::where('bill_id', $bill_id)->value('usertype_id');
                    $order->customer_id = $cid;
                    $order->usertype_id = $uid;
                    $order->bill_id = $bill_id;
                    $order->item_id = $calc_item_id;
                    $order->unit_id = $calc_unit_id;
                    $order->category_id = $calc_cat_id;
                    $order->quantity = $value['quantity'];
                    // $ca_discount = $value['quantity']*($calc_discount);
                    // $cal_tot = $value['quantity']*($calc_rate - $calc_discount);
                    $order->total = $cal_tot;
                    $order->date = $current_date;
                    $order->date_np = $this->helper->date_np_con();
                    $order->time = $current_time;
                    $order->is_confirmed = '0';
                    $order->bill_type = '1';
                    $order->item_type_id = $calc_item_type_id;
                    $order->status = '1';
                    $order->created_by = $auth;
                    $order->save();
                }
            }
                // $calc_gtotal += $cal_tot;
                // $cal_discount += $ca_discount;
            }
            // $detail_id = Order_detail::where('bill_id', $bill_id)->value('id');
            // $req_disc = $cal_discount + $request->mdiscount;
            // $req_total = $calc_gtotal - $request->mdiscount;
            // $order_total = Order_detail::find($detail_id);
            // $order_total->bill_id = $bill_id;
            // $order_total->total = $calc_gtotal;
            // $order_total->discount = $req_disc;
            // $order_total->grand_total = $req_total;
            // $order_total->customer_id = $request->user_id;
            // $order_total->date = $current_date;
            // $order_total->received = $req_total;
            // $order_total->is_active = '1';
            // $order_total->is_confirmed = '1';
            // $order_total->bill_type = $request->type_id;
            // $order_total->created_by = $auth;
            // $order_total->save();
        
        return response()->json([
            'message'=>'ok',
            'bill_id' => $bill_id
        ],200);
    }

    public function bill($bill){
        $bills = Order_detail::where('bill_id', $bill)->with('orderstatus','customer','table','createdUser')->first();
        return response()->json([
            'reviewbills'=>$bills
        ],200);
    }

    public function befbill($bill){
        $bills = Order_detail::where('bill_id', $bill)->with('orderkitchenprevious','customer','table','createdUser')->first();
        return response()->json([
            'befreviewbills'=>$bills
        ],200);
    }

    public function destroy($id){
        $orders = Order::findOrFail($id);
        $orders->delete();
        return ['message'=>'ok'];
    }
}