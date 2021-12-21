<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stock;
use App\VendorDetail;
use Auth;
use App\Configure;
use App\IncomeExpenseTopic;
use App\IncomeExpense;

class AssetController extends Controller
{
    public function index(Request $request){
        // dd($request->vendor_id);
        $posts = Stock::orderBy('id','DESC')->where('type','4')->where('vendor_id',$request->assetid)->with('category','unit','bought');
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
           'assets' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        // dd('kk');
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'rate' => 'required',
        ]);


       
        // dd($request);
        // dd($request->unit_id);
        $total = ($request['quantity'] * $request['rate']) +$request['vat'];
        $finduser = VendorDetail::find($request->assetid);
        // dd($finduser->bought_user_id);

        $configure = Configure::where('is_active',1)->first();
        // dd($configure->expense_asset,$configure);
        if($configure->expense_asset == 1){
        

          $incometopic = IncomeExpenseTopic::firstOrCreate([
              'name' => 'Asset'
          ], [
              'name' => 'Asset',
              'type' => '1',
              'slug' => strtolower('Asset'),
              'is_active' => '1',
              'date' => date("Y-m-d"),
              'date_np' => $this->helper->date_np_con(),
              'time' => date("H:i:s"),
              'created_by' => Auth::user()->id,
          ]);
          $incomeexpense_id = IncomeExpenseTopic::where('name','Asset')->value('id');


          $incomeexpense = IncomeExpense::create([
             'topic_id' => $incomeexpense_id,
             'description' => 'Asset details',
             'amount' => $total,
             'iedate' => $this->helper->date_np_con(),
             'type' => '1',
             'is_active' => '1',
             'date' => date("Y-m-d"),
             'date_np' => $this->helper->date_np_con(),
             'time' => date("H:i:s"),
             'created_by' => Auth::user()->id,
          ]);
        }

        return Stock::create([
           'name' => $request['name'],
           'slug' => str_replace(' ', '-', strtolower($request['name'])).'-'.rand(1000,9999),
           'price' => $request['price'],
           'vendor_id' => $request['assetid'],
           'unit_id' => $request['unit_id'],
           'category_id' => $request['category_id'],
           'quantity' => $request['quantity'],
           'rate' => $request['rate'],
           'vat' => $request['vat'],
           'total' => $total,
           'bought_user_id' => $finduser->bought_user_id,
           'is_active' => '1',
           'type' => '4',
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
    public function show($id){
        
    }
}