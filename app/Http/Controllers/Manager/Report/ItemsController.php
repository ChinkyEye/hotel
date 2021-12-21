<?php

namespace App\Http\Controllers\Manager\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Auth;
use DB;

use App\Exports\Manager\ItemReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemsController extends Controller
{
    public function index(Request $request){
      $posts = Order::orderBy('id','DESC');
      if($request->has('category_id') && $request->get('category_id')!="")
        {            
          $posts = $posts->where('category_id', $request->category_id);
        }
      if($request->has('item_id') && $request->get('item_id')!="")
        {            
          $posts = $posts->where('item_id', $request->item_id);
        }
      if((!empty($request->date1)) || (!empty($request->date2)))
        {
          $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
        }
        // $total = $posts->where('is_confirmed','1')->sum('total');
        $posts = $posts->with('item','unit')->where('is_confirmed','1')
                ->select('*', DB::raw('sum(quantity) as sumqty'))
                ->groupBy('item_id')
                ->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'confirmorders' => $posts,
           // 'total' => $total,
       ];
       return response()->json($response);
    }

    public function fileExport(Request $request) 
    {
      $filename = 'itemReport.xlsx';
      return Excel::download(new ItemReportExport($request->category_id, $request->item_id, $request->start_date, $request->end_date), $filename);
    }
}