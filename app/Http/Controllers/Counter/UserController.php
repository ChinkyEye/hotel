<?php

namespace App\Http\Controllers\Counter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Usertype;

class UserController extends Controller
{
    // public function index(Request $request){
    //   $posts = User::orderBy('id','DESC')->with('usertype','getSalary','userpackage');
    //   if(empty($request->search))
    //     {            
    //       $posts = $posts;
    //     }
    //   else{
    //         $search = $request->search;
    //         $posts = $posts->where('name', 'LIKE',"%{$search}%")->orWhere('user_code', 'LIKE',"%{$search}%")->orWhere('phone', 'LIKE',"%{$search}%");
    //     }
    //   if(empty($request->user_type))
    //   {
    //     $posts = $posts;
    //   }
    //   else{
    //     $user_type = $request->user_type;
    //     $posts = $posts->where('user_type_id','LIKE',"%{$user_type}%");
    //   }
    //     $posts = $posts->where('user_type','0')->paginate(15);
    //     $response = [
    //        'pagination' => [
    //            'total' => $posts->total(),
    //            'per_page' => $posts->perPage(),
    //            'current_page' => $posts->currentPage(),
    //            'last_page' => $posts->lastPage(),
    //            'from' => $posts->firstItem(),
    //            'to' => $posts->lastItem()
    //        ],
    //        'users' => $posts
    //    ];
    //    return response()->json($response);
    // }

    public function index(Request $request){
      $id = $request->type;
      $user_type_name = Usertype::where('id',$id)->value('name');
      $posts = User::orderBy('id','DESC')->where('user_type_id', $id)->where('user_type','0')->with('usertype','getSalary','userpackage','getPack');
      if(!empty($request->search))
        {            
            $posts = $posts->where('user_code', 'LIKE',"%{$request->search}%");
        }
        $posts = $posts->where('user_type','0')->where('user_type','0')->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'user_type_name' => $user_type_name,
           'users' => $posts,
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'user_type' => 'required',
            'name' => 'required',
            // 'phone' => 'required',
            // 'address' => 'required',
        ]);

        $type_id = Usertype::where('id', $request['user_type'])->value('type_id');
        if($request['email']){
          $email = $request['email'];
        }
        else{
          $email = rand().'@techware.com.np';
        }
        return User::create([
           'name' => $request['name'],
           'user_code' => strtotime("now"),
           'email' => $email,
           'password' => $request['name'],
           'phone' => $request['phone'],
           'address' => $request['address'],
           'date_of_join' => $request['date_of_join'],
           'is_active' => '1',
           'user_type' => '0',
           'type_id' => $type_id,
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'user_type_id' => $request['user_type'],
        ]);
    }

    public function edit($id){
        $users = User::findOrFail($id);
        return response()->json([
            'users'=>$users
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'user_type_id' => 'required',
            'name' => 'required',
            // 'phone' => 'required',
            // 'address' => 'required',
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

    public function all_user_select(){
        $userss = User::orderBy('id','DESC')->where('type_id','2')->where('is_active','1')->select('id','name','user_code');
        if(request('type','')!='') $userss->where('user_type_id',request('type'));
        return response()->json([
            'userSelect'=>$userss->get()
        ],200);
    }

    public function all_user_buyer_select(){
        $userss = User::orderBy('id','DESC')->where('type_id','1')->where('is_active','1')->select('id','name','user_code');
        return response()->json([
            'buyerSelect'=>$userss->get()
        ],200);
    }

    public function all_user_salary_select(){
      $userss = User::orderBy('id','DESC')->where('type_id','2')->where('is_active','1')->select('id','name','user_code')->whereHas('getSalaryUser', function($q){
        $q->where('is_salary',True);
    })->get();
        return response()->json([
            'userSalarySelect'=>$userss
        ],200);
    }
}