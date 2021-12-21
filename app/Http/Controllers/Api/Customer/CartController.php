<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Cart;

class CartController extends Controller
{
  public function storeCart(Request $request) {

        $current_time = date("H:i:s");
        $current_date = date("Y-m-d");

        $cart = new Cart();
        $cart->quantity = $request->quantity;
        $cart->item_id = $request->item_id;
        $cart->time = $current_time;
        $cart->date_en = $current_date;
        $cart->created_by = Auth::user()->id;
        $cart->save();

       return response()->json([[
            'message'=>'added to cart'
        ]],200);
  }

  //get the list of cart items 
  public function get_cart_items(Request $request){
        $post = Cart::orderBy('id','DESC')
                  ->where('created_by',Auth::user()->id)
                  ->with('getItems.getunit')
                  ->get();

        return response()->json($post);
    }


      //delete items from cart lists
    public function deleteCartItems (Request $request) {

       $item_id = Cart::where('created_by', Auth::user()->id)
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
