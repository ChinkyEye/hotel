<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order_detail;
use Auth;

class CounterController extends Controller
{
  public function index(Request $request){
    $posts = Order_detail::where('is_confirmed','1');
    // if(!empty($request->search))
    //   {            
    //     $posts = $posts->where('bill_id', 'LIKE',"%{$request->search}%");
    //   }
    if(!empty($request->counter_id))
      {
        $posts = $posts->where('created_by','LIKE',"%{$request->counter_id}%");
      }
    // if(!empty($request->user_type))
    //   {
    //     $posts = $posts->where('usertype_id','LIKE',"%{$request->user_type}%");
    //   }
    // if(!empty($request->table_id))
    //   {
    //     $posts = $posts->where('table_id',$request->table_id);
    //   }
    if(($request->has('date1')) || ($request->has('date2')))
      {
        $total = $posts->where('is_confirmed','1')->sum('total');
        $discount = $posts->where('is_confirmed','1')->sum('discount');
        $grand_total = $posts->where('is_confirmed','1')->sum('grand_total');
        $received = $posts->where('is_confirmed','1')->sum('received');
        $post = $posts->groupBy('created_by','receive_type');
        //$posts = $posts->with('usertype','createdUser')->withCount('count')->where('is_confirmed','1')->paginate(15);
        $posts = $posts->selectRaw('order_details.id id, SUM(order_details.total) odt,SUM(order_details.grand_total) odgt, SUM(order_details.discount) odd, SUM(order_details.received) odr, order_details.receive_type ort, order_details.created_by odcb,users.name')->where('is_confirmed','1')
              ->join('users','order_details.created_by','=','users.id')
              ->orderByRaw('order_details.created_by, order_details.receive_type')
              ->whereBetween('order_details.date', [$request->date1, $request->date2])
              ->get();
      
      }

            // dd($posts);
      $response = [
         'counterorderdetails' => $posts,
         'total' => $total,
         'discount' => $discount,
         'grand_total' => $grand_total,
         'received' => $received,
     ];
     return response()->json($response);
  }
}