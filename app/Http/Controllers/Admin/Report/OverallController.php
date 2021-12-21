<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order_detail;
use App\User;
use Auth;

use App\Exports\Admin\OverallReportExport;
use Maatwebsite\Excel\Facades\Excel;

class OVerallController extends Controller
{
  public function index(Request $request){
      $posts = Order_detail::orderBy('id','DESC')->where('is_confirmed','1');
    if($request->has('counter_id') && ($request->get('counter_id') != ''))
        {
          $posts = $posts->where('created_by',$request->counter_id);
        }
    if(($request->has('date1')) || ($request->has('date2')))
        {
          $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
        }
    if($request->has('receive_type') && ($request->get('receive_type') != ''))
        {
          $posts = $posts->where('receive_type',$request->receive_type);
        }
    if(($request->get('receive_type')==0 || $request->get('receive_type')=='') && ($request->has('bill_type') && $request->get('bill_type')!=""))
        {
          $posts = $posts->where('bill_type',$request->bill_type);
        }
      $total = $posts->sum('total');
      $discount = $posts->sum('discount');
      $grand_total = $posts->sum('grand_total');
      $received = $posts->sum('received');

      $posts = $posts->with('customer','usertype','table','createdUser')->withCount('count')->paginate(15);
      $response = [
         'pagination' => [
             'total' => $posts->total(),
             'per_page' => $posts->perPage(),
             'current_page' => $posts->currentPage(),
             'last_page' => $posts->lastPage(),
             'from' => $posts->firstItem(),
             'to' => $posts->lastItem()
         ],
         'userorderoveralldetails' => $posts,
         'total' => $total,
         'discount' => $discount,
         'grand_total' => $grand_total,
         'received' => $received,
     ];
     return response()->json($response);
  }

  public function fileExport(Request $request) 
    {
      $filename = 'overallReport.xlsx';
      return Excel::download(new OverallReportExport($request->counter_id,$request->receive_type,$request->bill_type, $request->start_date, $request->end_date), $filename);
    }
}