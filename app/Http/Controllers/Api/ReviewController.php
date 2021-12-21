<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Pre_order;
use App\Order;
use App\Order_detail;
use App\Item;

class ReviewController extends Controller
{
    //
 // public function get_review_order(Request $request) {

 //    $pre_order = Pre_order::create([
 //            'quantity' => $request['quantity'],
 //            'item_id' => $request['item_id'],
 //            'table_id' => $request['table_id'],
 //            'user_id' => $request['user_id'],
 //            'created_by' => Auth::user()->id,
 //        ]);

 //    // var_dump($pre_order);
 //    // die();
 //    // // yo ho? yes sir // store ko ho ani display ko esko muni ko ho
 //        $pass = array(
 //            'data' => Pre_order::where('created_by', Auth::user()->id)
 //                            ->where('id',$pre_order->id)
 //                            ->orderBy('id', 'DESC')
 //                            ->with('getItems')
 //                            ->first(),
 //            'message' => 'Data added successfully!',
 //            'alert-type' => 'success'
 //        );
 //        //return back()->with($pass)->withInput();
 //        return response()->json([$pass]);
 //  }


  //get the list of order which is not confirmed
  public function get_review_order_billId(Request $request){
        $post = Order_detail::orderBy('id','DESC')
                  ->where('bill_id',$request['bill_id'])
                  ->where('is_confirmed','0')
                  ->with('customer')
                  ->with('table')
                  ->get();

        return response()->json($post);
    }



     public function get_bill_from_table(Request $request){
        $post = Order_detail::orderBy('id','DESC')
                  ->where('table_id',$request['table_id'])
                  ->where('is_confirmed','0')
                  ->get('bill_id');

        return response()->json($post);
    }



    // public function get_review_order_usertype_id(Request $request){
    //     $post = Order::orderBy('id','DESC')
    //               ->where('usertype_id',$request['usertype_id'])
    //               ->where('is_confirmed','0')
    //               ->with('item')
    //               ->get();

    //     return response()->json($post);
    // }

    // public function get_review_order_table(Request $request){
    //     $post = Order_detail::orderBy('id','DESC')
    //               ->where('table_id',$request['table_id'])
    //               ->where('is_confirmed','0')
    //               ->get();
    //     return response()->json($post);
    // }


//get bill id in spinner in android
     public function get_bill_id(Request $request){
        $post = Order_detail::orderBy('id','DESC')
                  ->where('is_confirmed','0')
                  ->get('bill_id');
        return response()->json($post);
    }

    //get list of table from order_details table 
     public function get_table_list(Request $request){
        $post = Order_detail::orderBy('id','DESC')
                  ->where('is_confirmed','0')
                  ->with('table')
                  ->get('table_id');
        return response()->json($post);
    }


    //add review order
    public function store_review_order(Request $request) {
        $bill_id = $request->bill_id;
        $item_id = $request->id;
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $auth = Auth::user()->id;

        $calc_total='0';

       // $table_id= $request->table_id;

        $mycarts = Item::orderBy('id','DESC')
                  ->where('id',$request['id'])
                  ->get();

        $total = Order::orderBy('id','DESC')
                  ->where('item_id',$request['id'])
                  ->where('bill_id',$bill_id)
                  ->sum('total');

        $quantity=Order::orderBy('id','DESC')
                  ->where('item_id',$request['id'])
                  ->where('bill_id',$bill_id)
                  ->sum('quantity');

                  // dd($total);

                  $bill_item=Order::where('bill_id', $bill_id)->where('item_id', $item_id)->exists();

                  if ($bill_item) {
                    $item = Item::find($item_id);
                    // dd($item->price);
                   // dd($total,$quantity);

                    $order_id = Order::where('bill_id', $bill_id)->where('item_id', $item_id)->value('id');
                    $orderupdate = Order::find($order_id);

                    $valuetotal = $orderupdate->quantity+$request->quantity;
                    
                    $orderupdate->quantity = $orderupdate->quantity+$request->quantity;
                    $orderupdate->total =  $valuetotal*$item->price;
                    $orderupdate->date = $current_date;
                    $orderupdate->date_np = $this->helper->date_np_con();
                    $orderupdate->time = $current_time;
                    $orderupdate->update();

                    return response()->json([[
                  'message'=>'records Updated'
                   ]],200);
                    
                  }


                 else
                   {
                   //  dd('there');
                    foreach ($mycarts as $key => $value) {
      
                    $order = New Order();
                    $order->customer_id = '9';
                    $order->usertype_id = '14';
                    $order->bill_id = $bill_id;
                    $order->item_id = $value->id;
                    $order->category_id = $value->category_id;
                    $order->unit_id = $value->unit_id;
                    $order->quantity = $request->quantity;
                    $order->total = $value->price*$order->quantity;  
                    $order->is_confirmed = '0';
                    $order->bill_type = '0';
                    $order->item_type_id = $value->item_type_id;
                    $order->status = '1';
                    $order->is_active = '1';
                    $order->created_by = $auth;
                    $order->date_np = $this->helper->date_np_con();
                    $order->date = $current_date;
                    $order->time = $current_time;
                    $order->save();


                  return response()->json([[
                  'message'=>'records created',
                  'bill_id' => $bill_id
                   ]],200);


          }

       }
          



        // var_dump($request['id']);
        // die();

    
           // $calc_total += $value->getItems->price*$value['quantity'];
        
            // $cartsDetail = Order_detail::orderBy('id','DESC')
            //       ->where('bill_id',$bill_id)
            //       ->get();

            //        foreach ($cartsDetail as $key => $values) {

            //         if (Order_detail::where('bill_id', $bill_id)->exists()) {
            //         $mycartsDetail = Order_detail::find($values->id);
            //        // $mycartsDetail->total = $values->total+'50';
        
            //         $mycartsDetail->save();
            //        }

  //}


      }

}
