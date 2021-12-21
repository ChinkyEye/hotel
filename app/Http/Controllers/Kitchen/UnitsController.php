<?php

namespace App\Http\Controllers\Kitchen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Unit;
use Auth;

class UnitsController extends Controller
{
    public function index(Request $request){
      $posts = Unit::orderBy('id','DESC');
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
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
           'units' => $posts
       ];
       return response()->json($response);
    }

    public function status($id, $avi){
        $units = Unit::findOrFail($id);
        $units->is_active = !$avi;
        $units->save();
    }

    public function all_unit_select(){
        $unitSelect = Unit::orderBy('id','DESC')->where('is_active','1')->select('id','name')->get();
        return response()->json([
            'unitSelect'=>$unitSelect
        ],200);
    }
}