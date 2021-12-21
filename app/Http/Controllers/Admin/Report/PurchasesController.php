<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Stock;
use Auth;
use DB;

use App\Exports\Admin\PurchaseReportExport;
use Maatwebsite\Excel\Facades\Excel;

class PurchasesController extends Controller
{
    public function index(Request $request){
        // dd('jj');

         $posts = Stock::orderBy('id','DESC');
         if(!empty($request->buyer_id))
           {            
             $posts = $posts->where('bought_user_id', 'LIKE',"%{$request->buyer_id}%");
           }
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
        
         if($request->date1 || $request->date2 ){
             $posts = $posts->whereBetween('date',[$request->date1, $request->date2]);
         }
         $posts = $posts->with('category','unit','bought')->paginate(15);
         $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'purchaseorderdetails' => $posts
        ];
        return response()->json($response);
   
    }

    public function fileExport(Request $request) 
      {
        // dd('ok');
        // dd($request);
        $filename = 'purchasesReport.xlsx';
        return Excel::download(new PurchaseReportExport($request->buyer_id, $request->search, $request->category_id, $request->start_date, $request->end_date), $filename);
      }
}
