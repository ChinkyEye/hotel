<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\VendorDetail;
use Auth;

class VendorAssetController extends Controller
{

    public function index(Request $request){
      $posts = VendorDetail::orderBy('id','DESC')->where('type_id','1')->where('created_by', Auth::user()->id);
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('bill_id', 'LIKE',"%{$search}%");
        }
        $posts = $posts->with('bought')->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'vendorassets' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        // dd($request);
        // dd('heyvender');
        // $this->validate($request, [
        //     'bill_id' => 'required',
        //     'buyer_id' => 'required',
        // ]);
        // dd($request->date);

        return VendorDetail::create([
           'bill_id' => $request['billid'],
           'bought_user_id' => $request['buyer_id'],
           'is_active' => '1',
           'type_id' => '1',
           'date' => $request['date'],
           'date_np' => $this->helper->date_np_con_parm($request['date']),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $vendors = VendorDetail::findOrFail($id);
        return response()->json([
            'vendors'=>$vendors
        ],200);
    }

    public function update(Request $request, $id)
    {   
        // $this->validate($request, [
        //     'name' => 'required',
        // ]);
        $vendors = VendorDetail::findOrFail($id);
        $vendors->update($request->all());
    }

     public function destroy($id){
        $vendors = VendorDetail::findOrFail($id);
        $vendors->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $vendors = VendorDetail::findOrFail($id);
        $vendors->is_active = !$avi;
        $vendors->save();
    }
}
