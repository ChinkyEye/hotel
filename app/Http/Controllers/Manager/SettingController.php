<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Auth;

class SettingController extends Controller
{
   public function index(Request $request){
     $posts = Setting::orderBy('id','DESC');
     if(empty($request->search))
     {            
       $posts = $posts;
     }
     else{
       $search = $request->search;
       $posts = $posts->where('name', 'LIKE',"%{$search}%");
     }
     $posts = $posts->paginate(30);
     $response = [
       'pagination' => [
         'total' => $posts->total(),
         'per_page' => $posts->perPage(),
         'current_page' => $posts->currentPage(),
         'last_page' => $posts->lastPage(),
         'from' => $posts->firstItem(),
         'to' => $posts->lastItem()
       ],
       'settings' => $posts
     ];
     return response()->json($response);
   }

   public function store(Request $request)
   {  
     $this->validate($request, [
       'name' => 'required',
       'address' => 'required',
       'phone' => 'required',
     ]);
     if($request['date_np'] == null)
     {
        $request['date_np'] = $this->helper->date_np_con(); 

     }
     else{
        $request['date_np'] = $this->helper->date_np_con_parm($request['date_np']);
     }
     Setting::create([
       'name' => $request['name'],
       'address' => $request['address'],
       'email' => $request['email'],
       'pan' => $request['pan'],
       'phone' => $request['phone'],
       'footer_quote1' => $request['footer_quote1'],
       'footer_quote2' => $request['footer_quote2'],
       'fiscalyear_id' => $request['fiscalyear_id'],
       'taxamount' => $request['taxamount'],
       'date' => date("Y-m-d"),
       'date_np' => $this->helper->date_np_con(),
       'time' => date("H:i:s"),
       'is_active' => '1',
       'created_by' => Auth::user()->id,
     ]);
     return ['message' => 'Setting Created'];
   }

   public function edit($id){
     $settings = Setting::findOrFail($id);
     return response()->json([
       'settings'=>$settings
     ],200);
   }

   public function update(Request $request, $id)
   {   
     $this->validate($request, [
       'name' => 'required',
       'address' => 'required',
       'phone' => 'required',
     ]);
     $user = Setting::findOrFail($id);
    
     $user->update([
       'name' => $request['name'],
       'address' => $request['address'],
       'email' => $request['email'],
       'pan' => $request['pan'],
       'phone' => $request['phone'],
       'footer_quote1' => $request['footer_quote1'],
       'footer_quote2' => $request['footer_quote2'],
       'taxamount' => $request['taxamount'],
       'time_np' => date("H:i:s"),
       'updated_by' => Auth::user()->id,
     ]);
     return ['message' => 'Setting Updated'];
   }

   public function destroy($id){
     $usertype = Setting::findOrFail($id);
     $usertype->delete();
     return ['message'=>'ok'];
   }

   public function status($id, $avi){
     $user = Setting::findOrFail($id);
     $user->is_active = !$avi;
     $user->save();
   }

   public function billsetting(Request $request){
     $posts = Setting::orderBy('id','DESC')->first();
     $response = [
       'settings' => $posts
     ];
     return response()->json($response);
   }
}
