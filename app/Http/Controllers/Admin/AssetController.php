<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stock;
use Auth;

class AssetController extends Controller
{
    public function index(Request $request){
        $posts = Stock::orderBy('id','DESC')->where('type','4');
        if(!empty($request->search))
          {            
            $posts = $posts->where('name', 'LIKE',"%{$request->search}%");
          }
        if(!empty($request->category_id))
        {
          $posts = $posts->where('category_id','LIKE',"%{$request->category_id}%");
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
           'assets' => $posts
       ];
       return response()->json($response);
    }

    public function destroy($id){
        $stocks = Stock::findOrFail($id);
        $stocks->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $stocks = Stock::findOrFail($id);
        $stocks->is_active = !$avi;
        $stocks->save();
    }
}