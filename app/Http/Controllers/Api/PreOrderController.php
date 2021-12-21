<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Pre_order;

class PreOrderController extends Controller
{
    //
 public function store(Request $request) {

    $pre_order = Pre_order::create([
            'quantity' => $request['quantity'],
            'item_id' => $request['item_id'],
            'table_id' => $request['table_id'],
            'user_id' => Auth::user()->id,
            'created_by' => Auth::user()->id,
        ]);

    // var_dump($pre_order);
    // die();
    // // yo ho? yes sir // store ko ho ani display ko esko muni ko ho
        $pass = array(
            'data' => Pre_order::where('created_by', Auth::user()->id)
                            ->where('id',$pre_order->id)
                            ->orderBy('id', 'DESC')
                            ->with('getItems')
                            ->first(),
            'message' => 'Data added successfully!',
            'alert-type' => 'success'
        );
        //return back()->with($pass)->withInput();
        return response()->json([$pass]);
  }


  //get the list of pre_order according to the table
  public function get_pre_order(Request $request){
        $post = Pre_order::orderBy('id','DESC')
                  ->where('table_id',$request['table_id'])
                 // ->where('user_id',$request['user_id'])
                  ->with('getItems.getunit')
                  ->get();

        return response()->json($post);
    }


    //delete from pre_order lists
    public function deletePreOrderItems (Request $request) {
       $item_id = Pre_order::where('created_by', Auth::user()->id)
                    ->find($request->id);

       if ($item_id->delete()) {
            return response()->json([[
          "message" => "records deleted"
        ]], 202);
    
        } 
        else{
           return response()->json([[
          "message" => "records not found"
        ]], 404); 
        }
     }
}
