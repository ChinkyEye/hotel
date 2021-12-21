<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stock;
use App\VendorDetail;
use Auth;

class StockController extends Controller
{
    public function index(Request $request){
        $posts = Stock::orderBy('id','DESC')->where('vendor_id',$request->vendor_id)->with('category','unit','bought');
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

        if(empty($request->type))
        {
          $posts = $posts;
        }
        else{
          $type = $request->type;
          $posts = $posts->where('type','LIKE',"%{$type}%");
        }

        if(empty($request->date))
        {
          $posts = $posts;
        }
        else{
          $date = $request->date;
          $posts = $posts->where('date','LIKE',"%{$date}%");
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
        // dd($request->quantity);
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'rate' => 'required',
            'type' => 'required',
        ]);
        // dd($request);
        // dd($request->unit_id);
        $total = ($request['quantity'] * $request['rate']) +$request['vat'];
        $finduser = VendorDetail::find($request->vendor_id);
        // dd($finduser->bought_user_id);

        return Stock::create([
           'name' => $request['name'],
           'slug' => str_replace(' ', '-', strtolower($request['name'])).'-'.rand(1000,9999),
           'price' => $request['price'],
           'vendor_id' => $request['vendor_id'],
           'unit_id' => $request['unit_id'],
           'category_id' => $request['category_id'],
           'quantity' => $request['quantity'],
           'qty_rem' => $request['quantity'],
           'rate' => $request['rate'],
           'vat' => $request['vat'],
           'type' => $request['type'],
           'total' => $total,
           'bought_user_id' => $finduser->bought_user_id,
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