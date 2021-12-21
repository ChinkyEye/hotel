<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Table;
use Auth;

class TableController extends Controller
{
    // public function index(Request $request){
    //     $posts = Table::orderBy('id','DESC')->paginate(15);
    //     $response = [
    //        'pagination' => [
    //            'total' => $posts->total(),
    //            'per_page' => $posts->perPage(),
    //            'current_page' => $posts->currentPage(),
    //            'last_page' => $posts->lastPage(),
    //            'from' => $posts->firstItem(),
    //            'to' => $posts->lastItem()
    //        ],
    //        'tables' => $posts
    //    ];
    //    return response()->json($response);
    // }

    // public function status($id, $avi){
    //     $tables = Table::findOrFail($id);
    //     $tables->is_active = !$avi;
    //     $tables->save();
    // }

    public function all_table_select(){
        $tables = Table::orderBy('id','DESC')->where('is_active','1')->where('id','!=','1')->select('id','name')->get();
        return response()->json($tables);
    }
}