<?php

namespace App\Http\Controllers\Counter\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order_detail;
use App\User;
use Auth;

class CustomerController extends Controller
{
  public function index(Request $request){
    $name = User::where('id',$request->user_id)->value('name');
    $address = User::where('id',$request->user_id)->value('address');
    $user_code = User::where('id',$request->user_id)->value('user_code');
    $phone = User::where('id',$request->user_id)->value('phone');
    $posts = Order_detail::orderBy('id','DESC')->where('receive_type','0')->where('is_confirmed','1')->where('created_by',Auth::user()->id)->where('customer_id',$request->user_id);
      $total = $posts->sum('total');
      $discount = $posts->sum('discount');
      $grand_total = $posts->sum('grand_total');
      $receive = $posts->sum('received');
      $posts = $posts->with('table')->withCount('count')->where('is_confirmed','1')->paginate(15);
      $response = [
         'pagination' => [
             'total' => $posts->total(),
             'per_page' => $posts->perPage(),
             'current_page' => $posts->currentPage(),
             'last_page' => $posts->lastPage(),
             'from' => $posts->firstItem(),
             'to' => $posts->lastItem()
         ],
         'userorderdetails' => $posts,
         'total' => $total,
         'discount' => $discount,
         'grand_total' => $grand_total,
         'receive' => $receive,
         'name' => $name,
         'address' => $address,
         'user_code' => $user_code,
         'phone' => $phone,
     ];
     return response()->json($response);
  }

  public function pay(Request $request){
    $posts = Order_detail::orderBy('id','DESC')->where('receive_type','1')->where('bill_type','2')->where('is_confirmed','1')->where('created_by',Auth::user()->id)->where('customer_id',$request->user_id);
      $total = $posts->sum('received');
      $posts = $posts->with('table')->paginate(15);
      $response = [
         'pagination' => [
             'total' => $posts->total(),
             'per_page' => $posts->perPage(),
             'current_page' => $posts->currentPage(),
             'last_page' => $posts->lastPage(),
             'from' => $posts->firstItem(),
             'to' => $posts->lastItem()
         ],
         'userpaydetails' => $posts,
         'paytotal' => $total,
     ];
     return response()->json($response);
  }
}