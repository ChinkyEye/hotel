<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order_detail;
use App\Order;
use App\Stock;
// use App\Order_has_return;
// use App\Customer_has_transaction;
use Auth;

class DaybookController extends Controller
{
    public function index(Request $request){
      $posts = Order_detail::orderBy('id','DESC')->where('date',$request->date)->where('bill_type','0')->where('is_active','1')->get();
      $count = Order_detail::orderBy('id','DESC')->where('date',$request->date)->where('bill_type','0')->where('is_active','1')->count();
      // dd($count);
      $bill_cancel = Order_detail::orderBy('id','DESC')->where('date',$request->date)->where('bill_type','0')->where('is_active','0')->count();
      $bill_sold = Order_detail::orderBy('id','DESC')->where('date',$request->date)->where('bill_type','0')->where('is_active','1')->count();
      $quantity = Order::orderBy('id','DESC')->where('date',$request->date)->where('is_active','1')->sum('quantity');
      $quantity_return = '7';
      // $sold_return = Order_has_return::orderBy('id','DESC')->where('date',$request->date)->where('is_active','1')->sum('amount');
      $sold_return = '5';
      $due_received = Order_detail::orderBy('id','DESC')->where('date',$request->date)->where('is_active','1')->where('bill_type','1')->sum('grand_total');
      // dd($due_received);
      $amount_transferred = '9';
      $amount_purchase = Stock::orderBy('id','DESC')->where('date',$request->date)->where('is_active','1')->count();
      if($count){
        foreach ($posts as $key => $value) {
          $total = $value->where('bill_type','0')->where('date',$request->date)->where('is_active','1')->sum('total');
          $discount = $value->where('bill_type','0')->where('date',$request->date)->where('is_active','1')->sum('discount');
          $grand_total = $value->where('bill_type','0')->where('date',$request->date)->where('is_active','1')->sum('grand_total');
          $received = $value->where('bill_type','0')->where('date',$request->date)->where('is_active','1')->sum('received');

          $remain_grand_total = $value->where('bill_type','1')->where('date',$request->date)->where('is_active','1')->sum('grand_total');
          $remain_received = $value->where('bill_type','1')->where('date',$request->date)->where('is_active','1')->sum('received');

          $due = $remain_grand_total - $remain_received;
          // dd($due);
          // $due = $grand_total - $received;
        }
      }
      else{
        $total = 0;
        $discount = 0;
        $grand_total = 0;
        $due = 0;
      }
      $response = [
         'total' => $total,
         'discount' => $discount,
         'grand_total' => $grand_total,
         'due' => $due,
         'quantity' => $quantity-$quantity_return,
         'due_received' => $due_received,
         'amount_transferred' => $amount_transferred,
         'bill_cancel' => $bill_cancel,
         'bill_sold' => $bill_sold,
         'sold_return' => $sold_return,
         'amount_purchase' => $amount_purchase,
     ];
     return response()->json($response);
    }
}
