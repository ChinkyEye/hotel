<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Auth;

class CategoryBuyingController extends Controller
{
   public function index(Request $request){
     $posts = Category::orderBy('id','DESC')->where('type_id',1);
     if(empty($request->search))
       {            
         $posts = $posts;
       }
     else{
           $search = $request->search;
           $posts = $posts->where('name', 'LIKE',"%{$search}%");
       }
       $posts = $posts->paginate(15);
       $response = [
          'pagination' => [
              'total' => $posts->total(),
              'per_page' => $posts->perPage(),
              'current_page' => $posts->currentPage(),
              'last_page' => $posts->lastPage(),
              'from' => $posts->firstItem(),
              'to' => $posts->lastItem()
          ],
          'buyingcategories' => $posts
      ];
      return response()->json($response);
   }

   public function status($id, $avi){
       $user = Category::findOrFail($id);
       $user->is_active = !$avi;
       $user->save();
   }

}
