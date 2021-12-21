<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stock;
use Auth;
use DB;

use App\Exports\Admin\AssetReportExport;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index(Request $request){
         $posts = Stock::orderBy('id','DESC')->where('type','4');
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
            'assetreports' => $posts
        ];
        return response()->json($response);
     }

    public function fileExport(Request $request) 
      {
        $filename = 'assetReport.xlsx';
        return Excel::download(new AssetReportExport($request->buyer_id, $request->search, $request->category_id), $filename);
      }
}
