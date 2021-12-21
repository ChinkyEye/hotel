<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Item;
use Auth;
use DB;
use App\Exports\Admin\StockReportExport;
use Maatwebsite\Excel\Facades\Excel;

class StocksController extends Controller
{
    public function index(Request $request){
         $posts = Item::orderBy('id','DESC')->where('item_type_id','!=',2);
       
         if(!empty($request->search))
           {            
             $posts = $posts->where('name', 'LIKE',"%{$request->search}%");
           }
         if(!empty($request->category_id))
         {
           $posts = $posts->where('category_id','LIKE',"%{$request->category_id}%");
         }
         if(!empty($request->manager_id))
         {
           $posts = $posts->where('created_by','LIKE',"%{$request->manager_id}%");
         }
         if(!empty($request->type))
         {
           $posts = $posts->where('item_type_id','LIKE',"%{$request->type}%");
         }

         // if(!empty($request->date))
         // {
         //   $posts = $posts->where('created_at','LIKE',"%{$request->date}%");
         // }
         // if($request->date1 || $request->date2 ){
         //     $posts = $posts->whereBetween('date',[$request->date1, $request->date2]);
         // }
         $posts = $posts->with('category','unit')->paginate(15);
         // $posts = $posts->paginate(15);
         $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'stockdetails' => $posts
        ];
        return response()->json($response);
        
        }

    public function fileExport(Request $request) 
      {
        // dd('hello stck');
        // dd($request);
        $filename = 'stocksReport.xlsx';
        return Excel::download(new StockReportExport($request->search, $request->category_id, $request->type, $request->start_date, $request->end_date), $filename);
      }
}
