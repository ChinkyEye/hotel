<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Table;
use Auth;

class TableController extends Controller
{
    public function index(Request $request){
        $posts = Table::orderBy('id','DESC')->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'tables' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);

        return Table::create([
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
        $tables = Table::findOrFail($id);
        return response()->json([
            'tables'=>$tables
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $tables = Table::findOrFail($id);
        $tables->update($request->all());
    }

     public function destroy($id){
        $tables = Table::findOrFail($id);
        $tables->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $tables = Table::findOrFail($id);
        $tables->is_active = !$avi;
        $tables->save();
    }

    public function all_table_select(){
        $items = Table::orderBy('id','DESC')->where('is_active','1')->select('id','name')->get();
        return response()->json([
            'tableSelect'=>$items
        ],200);
    }
}