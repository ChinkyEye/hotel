<?php

namespace App\Http\Controllers\Kitchen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stock;
use Auth;

class StockController extends Controller
{
    public function index(Request $request){
        $posts = Stock::orderBy('id','DESC')->where('type',1)->with('category','unit','bought');
        if(empty($request->search))
          {            
            $posts = $posts;
          }
        else{
              $search = $request->search;
              $posts = $posts->where('name', 'LIKE',"%{$search}%");
          }
        if(empty($request->category_id))
        {
          $posts = $posts;
        }
        else{
          $category_id = $request->category_id;
          $posts = $posts->where('category_id','LIKE',"%{$category_id}%");
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
           'stocks' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'buyer_id' => 'required',
        ]);

        return Stock::create([
           'name' => $request['name'],
           'slug' => str_replace(' ', '-', strtolower($request['name'])).'-'.rand(1000,9999),
           'price' => $request['price'],
           'unit_id' => $request['unit_id'],
           'category_id' => $request['category_id'],
           'quantity' => $request['quantity'],
           'bought_user_id' => $request['buyer_id'],
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $stocks = Stock::findOrFail($id);
        return response()->json([
            'stocks'=>$stocks
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $stocks = Stock::findOrFail($id);
        $stocks->update($request->all());
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