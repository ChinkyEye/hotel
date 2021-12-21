<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;
use App\Exports\Admin\RoomReportExport;
use Maatwebsite\Excel\Facades\Excel;

class RoomReportController extends Controller
{
    public function index(Request $request){
      $posts = Room::orderBy('id','DESC');
      $total = 0;
      // if((!empty($request->date1)) || (!empty($request->date2)))
      //   {
      //     $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
      //     $total = $posts->sum('amount');
      //   }

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
           'roomreports' => $posts,
           'total' => $total,
       ];
       return response()->json($response);
    }

    public function fileExport(Request $request) 
    {
        // dd($request);
        $filename = 'roomReport.xlsx';
        return Excel::download(new RoomReportExport($request->start_date, $request->end_date), $filename);
    }
}
