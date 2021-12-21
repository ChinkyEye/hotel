<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Usertype;
use Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index(Request $request){
      $posts = User::orderBy('id','DESC')->where('user_type','2')->where('type_id','0');
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->where('user_type','2')->where('type_id','0')->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'managers' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {  
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $user_type = Usertype::where('level_id','2')->where('is_active','1')->value('id');
        return User::create([
           'name' => $request['name'],
           'user_code' => strtotime("now"),
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'phone' => $request['phone'],
           'address' => $request['address'],
           'is_active' => '1',
           'user_type' => '2',
           'type_id' => '0',
           'user_type_id' => $user_type,
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
        ]);
    }

    public function edit($id){
        $managers = User::findOrFail($id);
        return response()->json([
            'managers'=>$managers
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy($id){
        $usertype = User::findOrFail($id);
        $usertype->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $user = User::findOrFail($id);
        $user->is_active = !$avi;
        $user->save();
    }

    public function all_counter_select(){
        $items = User::orderBy('id','DESC')->where('is_active','1')->where('user_type','3')->select('id','name')->get();
        return response()->json([
            'counterSelect'=>$items
        ],200);
    }

    public function all_waiter_select(){
        $items = User::orderBy('id','DESC')->where('is_active','1')->where('user_type','4')->select('id','name')->get();
        return response()->json([
            'waiterSelect'=>$items
        ],200);
    }

    public function all_manager_select(){
        $items = User::orderBy('id','DESC')->where('is_active','1')->where('user_type','2')->select('id','name')->get();
        return response()->json([
            'managerSelect'=>$items
        ],200);
    }
}