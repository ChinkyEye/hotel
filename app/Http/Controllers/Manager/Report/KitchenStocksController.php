<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stock;
use Auth;
use DB;
use App\Exports\Admin\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;

class KitchenStocksController extends Controller
{
    public function index(Request $request){
         $posts = Stock::orderBy('id','DESC')->where('type',2);
       
         if(!empty($request->search))
           {            
             $posts = $posts->where('name', 'LIKE',"%{$request->search}%");
           }
         if(!empty($request->category_id))
         {
           $posts = $posts->where('category_id','LIKE',"%{$request->category_id}%");
         }
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
            'kitchenstockdetails' => $posts
        ];
        return response()->json($response);
        
        }

    public function fileExport(Request $request) 
      {
        $filename = 'kitchenStockReport.xlsx';
        return Excel::download(new SalesReportExport($request->bill_id, $request->user_type, $request->table_id, $request->bill_type, $request->start_date, $request->end_date), $filename);
      }
}
