<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stock;
use App\StockHasOut;

class PurchaseListsController extends Controller
{
    public function index(Request $request){
      // dd($request);
         $posts = Stock::orderBy('id','DESC')->with('category','unit','bought');
         if(empty($request->search))
           {            
             $posts = $posts;
           }
         else{
               $search = $request->search;
               $posts = $posts->where('name', 'LIKE',"%{$search}%");
           }
         if(empty($request->category_id))
         {
           $posts = $posts;
         }
         else{
           $category_id = $request->category_id;
           $posts = $posts->where('category_id','LIKE',"%{$category_id}%");
         }

         if(empty($request->type))
         {
           $posts = $posts;
         }
         else{
           $type = $request->type;
           $posts = $posts->where('type','LIKE',"%{$type}%");
         }

         if(empty($request->date))
         {
           $posts = $posts;
         }
         else{
           $date = $request->date;
           $posts = $posts->where('date','LIKE',"%{$date}%");
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
            'purchaselists' => $posts
        ];
        return response()->json($response);
       
    }

    public function stockoutlist(Request $request,$id){
      // dd($request);
      // dd($id);
         $posts = StockHasOut::orderBy('id','DESC')->where('stock_id',$id);
         // if(empty($request->search))
         //   {            
         //     $posts = $posts;
         //   }
         // else{
         //       $search = $request->search;
         //       $posts = $posts->where('name', 'LIKE',"%{$search}%");
         //   }
         // if(empty($request->category_id))
         // {
         //   $posts = $posts;
         // }
         // else{
         //   $category_id = $request->category_id;
         //   $posts = $posts->where('category_id','LIKE',"%{$category_id}%");
         // }

         // if(empty($request->type))
         // {
         //   $posts = $posts;
         // }
         // else{
         //   $type = $request->type;
         //   $posts = $posts->where('type','LIKE',"%{$type}%");
         // }

         // if(empty($request->date))
         // {
         //   $posts = $posts;
         // }
         // else{
         //   $date = $request->date;
         //   $posts = $posts->where('date','LIKE',"%{$date}%");
         // }

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
            'stockoutlists' => $posts
        ];
        return response()->json($response);
       
    }
}
