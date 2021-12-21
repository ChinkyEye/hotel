<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bill_has_sn;
use Auth;

use App\Exports\Admin\BillReportExport;
use Maatwebsite\Excel\Facades\Excel;

class BillController extends Controller
{
  public function index(Request $request){
    $posts = Bill_has_sn::orderBy('bill_sn','DESC');
    if($request->has('search') && $request->get('search')!="")
      {            
        $posts = $posts->where('bill_id', 'LIKE',"%{$request->search}%");
      }
    if(($request->has('date1')) || ($request->has('date2')))
      {
        $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
      }
      $posts = $posts->with('createdUser')->paginate(15);
      $response = [
         'pagination' => [
             'total' => $posts->total(),
             'per_page' => $posts->perPage(),
             'current_page' => $posts->currentPage(),
             'last_page' => $posts->lastPage(),
             'from' => $posts->firstItem(),
             'to' => $posts->lastItem()
         ],
         'confirmbilldetails' => $posts,
     ];
     return response()->json($response);
  }

  public function fileExport(Request $request) 
    {
      // dd('ok');
      $filename = 'billsReport.xlsx';
      return Excel::download(new BillReportExport($request->bill_id, $request->user_type, $request->table_id, $request->bill_type, $request->start_date, $request->end_date), $filename);
    }
}