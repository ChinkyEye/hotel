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

class WaiterController extends Controller
{
    public function index(Request $request){
      $posts = Order::orderBy('id','DESC');
      if($request->has('waiter_id') && $request->get('waiter_id')!="")
        {            
          $posts = $posts->where('created_by', $request->waiter_id);
        }
      if((!empty($request->date)))
        {
          $posts = $posts->where('date', $request->date);
        }
        $posts = $posts->with('item','unit')->paginate(15);
      

      $response = [
         'pagination' => [
             'total' => $posts->total(),
             'per_page' => $posts->perPage(),
             'current_page' => $posts->currentPage(),
             'last_page' => $posts->lastPage(),
             'from' => $posts->firstItem(),
             'to' => $posts->lastItem()
         ],
         'waiterreports' => $posts,
         // 'total' => $total,
     ];
     return response()->json($response);
    }
}
