<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stock;
use App\StockHasOut;
use Auth;

class PurchaseListsController extends Controller
{
    public function index(Request $request){
      // dd($request);
         $posts = Stock::orderBy('id','DESC')
                ->where('created_by', Auth::user()->id)
                ->with('category','unit','bought');
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
            'purchaselists' => $posts
        ];
        return response()->json($response);
       
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'quantiti' => 'required|numeric',
            'description' => 'required',
        ]);

      // dd($request);
      $findstockunit = Stock::find($request['id']);
      // dd($findstockunit);
      $findstockunit->qty_rem = $findstockunit->qty_rem - $request->quantiti;
      $findstockunit->update();

        return StockHasOut::create([
           'description' => $request['description'],
           'quantity' => $request['quantiti'],
           'stock_id' => $request['id'],
           'unit_id' => $findstockunit->unit_id,
           'is_active' => '1',
           'date' => $request['date'],
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function stock_out(Request $request, $id){
      $posts = Stock::with('unit')->findOrFail($id);
      $productreturns = StockHasOut::orderBy('id','DESC')->where('stock_id',$id)->sum('quantity');
      $outstocklists = StockHasOut::orderBy('id','DESC')->where('stock_id',$id)->get();
      return response()->json([
        'stocks'=>$posts,
        'stockouts'=>$productreturns,
        'outstocklists'=>$outstocklists,
      ],200);
    }

    public function stock_outlist(Request $request, $id){
      $outstocklists = StockHasOut::orderBy('id','DESC')->where('stock_id',$id)->get();
      return response()->json([
        'outstocklists'=>$outstocklists,
      ],200);
    }
}
