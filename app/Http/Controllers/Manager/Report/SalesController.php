<?php

namespace App\Http\Controllers\Manager\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order_detail;
use Auth;

use App\Exports\Manager\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
  public function index(Request $request){
    $posts = Order_detail::orderBy('id','DESC')->where('bill_type','!=','2')->where('receive_type','0')->where('is_confirmed','1');
    if($request->has('search') && $request->get('search')!="")
      {            
        $posts = $posts->where('bill_id', 'LIKE',"%{$request->search}%");
      }
    if($request->has('user_type') && $request->get('user_type')!="")
      {
        $posts = $posts->where('usertype_id','LIKE',"%{$request->user_type}%");
      }
    if($request->has('table_id') && $request->get('table_id')!="")
      {
        // var_dump($request->table_id);
        $posts = $posts->where('table_id',$request->table_id);
      }
    if($request->has('bill_type') && $request->get('bill_type')!=""){
        // var_dump($request->table_id);
        $posts = $posts->where('bill_type',$request->bill_type);
    }
    if(($request->has('date1')) || ($request->has('date2')))
      {
        $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
      }
      
      $total = $posts->sum('total');
      $discount = $posts->sum('discount');
      // $grand_total = $posts->sum('grand_total');
      $received = $posts->sum('received');
      $posts = $posts->with('customer','usertype','table')->withCount('count')->paginate(15);
      $response = [
         'pagination' => [
             'total' => $posts->total(),
             'per_page' => $posts->perPage(),
             'current_page' => $posts->currentPage(),
             'last_page' => $posts->lastPage(),
             'from' => $posts->firstItem(),
             'to' => $posts->lastItem()
         ],
         'confirmorderdetails' => $posts,
         'total' => $total,
         'discount' => $discount,
         // 'grand_total' => $grand_total,
         'received' => $received,
     ];
     return response()->json($response);
  }

  public function fileExport(Request $request) 
    {
      $filename = 'salesReport.xlsx';
      return Excel::download(new SalesReportExport($request->bill_id, $request->user_type, $request->table_id, $request->bill_type, $request->start_date, $request->end_date), $filename);
    }
}