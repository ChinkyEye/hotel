<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function loadDashboard(Request $request){
          // $current_date = date("Y-m-d");
          // $product_count = Product::where('date_en',$current_date)->where('is_active','1')->count();
          // $order_count = Order_detail::where('date_en',$current_date)->where('is_active','1')->count();
          // $stock_level_count = Product::where('date_en',$current_date)->where('is_active','1')->count();
          // $counter_count = User::where('user_type','4')->where('is_active','1')->count();
          // $bill_count = Order_detail::where('is_active','1')->count();
          // $bill_ageing_count = Order_detail::where('notify_day',$current_date)->where('is_active','1')->count();
          // $purchase_return = ProductHasReturn::where('date_en',$current_date)->count();
          // $top_item_sale = Order::where('date_en',$current_date)->count();
          // $top_item_customer = Order_detail::where('date_en',$current_date)->count();
          $response = [
             'product_count' => '1',
             'order_count' => '1',
             'stock_level_count' => '1',
             'counter_count' => '1',
             'bill_count' => '1',
             'bill_ageing_count' => '1',
             'purchase_return_count' => '1',
             'top_item_sale' => '1',
             'top_item_customer' => '1',
         ];
         return response()->json($response);
      }
}
