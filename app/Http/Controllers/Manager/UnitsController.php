<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Unit;
use Auth;

class UnitsController extends Controller
{
    public function index(Request $request){
      $posts = Unit::orderBy('id','DESC')->where('created_by', Auth::user()->id);
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

    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);

        return Unit::create([
           'name' => $request['name'],
           'slug' => str_replace(' ', '-', strtolower($request['name'])).'-'.rand(1000,9999),
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $units = Unit::findOrFail($id);
        return response()->json([
            'units'=>$units
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $units = Unit::findOrFail($id);
        $units->update($request->all());
    }

     public function destroy($id){
        $units = Unit::findOrFail($id);
        $units->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $units = Unit::findOrFail($id);
        $units->is_active = !$avi;
        $units->save();
    }

    public function all_unit_select(){
        $unitSelect = Unit::orderBy('id','DESC')
                        ->where('is_active','1')
                        // ->where('created_by', Auth::user()->id)
                        ->select('id','name')
                        ->get();
        return response()->json([
            'unitSelect'=>$unitSelect
        ],200);
    }
}