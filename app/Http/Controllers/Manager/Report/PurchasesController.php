<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Stock;
use Auth;
use DB;

use App\Exports\Admin\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;

class PurchasesController extends Controller
{
    public function index(Request $request){
         $posts = Stock::orderBy('id','DESC')->where('type','!=','4')->where('created_by', Auth::user()->id);
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
         if(!empty($request->type))
         {
           $posts = $posts->where('type','LIKE',"%{$request->type}%");
         }

         // if(!empty($request->date))
         // {
         //   $posts = $posts->where('created_at','LIKE',"%{$request->date}%");
         // }
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
        
       // $posts = Order::orderBy('id','DESC')->where('is_confirmed','1');
       // if($request->has('category_id') && $request->get('category_id')!="")
       //   {            
       //     $posts = $posts->where('category_id', $request->category_id);
       //   }
       // if($request->has('item_id') && $request->get('item_id')!="")
       //   {            
       //     $posts = $posts->where('item_id', $request->item_id);
       //   }
       // if((!empty($request->date1)) || (!empty($request->date2)))
       //   {
       //     $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
       //   }
       //   $total = $posts->where('is_confirmed','1')->sum('total');
       //   $posts = $posts->with('item','unit')->where('is_confirmed','1')
       //           ->select('*', DB::raw('sum(quantity) as sumqty'))
       //           ->groupBy('item_id')
       //           ->paginate(15);
       //   $response = [
       //      'pagination' => [
       //          'total' => $posts->total(),
       //          'per_page' => $posts->perPage(),
       //          'current_page' => $posts->currentPage(),
       //          'last_page' => $posts->lastPage(),
       //          'from' => $posts->firstItem(),
       //          'to' => $posts->lastItem()
       //      ],
       //      'purchaseorderdetails' => $posts,
       //      // 'total' => $total,
       //  ];
       //  return response()->json($response);
    }

    public function fileExport(Request $request) 
      {
        $filename = 'salesReport.xlsx';
        return Excel::download(new SalesReportExport($request->bill_id, $request->user_type, $request->table_id, $request->bill_type, $request->start_date, $request->end_date), $filename);
      }
}
