<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Usertype;

class UserController extends Controller
{
    
    public function customer_category(Request $request){

      $user_type_name = Usertype::where('type_id', '!=' , 0)
                                  ->where('type_id', '!=' , 1)->get();
     
       return response()->json($user_type_name);
    }

    
    public function user_select(Request $request){
        $userss = User::orderBy('id','DESC')
                  ->where('type_id','2')
                  ->where('is_active','1')
                  ->where('user_type_id',$request['user_type_id'])
                  ->get();

        return response()->json($userss);
    }

    // public function all_user_buyer_select(){
    //     $userss = User::orderBy('id','DESC')->where('type_id','1')->where('is_active','1')->select('id','name','user_code');
    //     return response()->json([
    //         'buyerSelect'=>$userss->get()
    //     ],200);
    // }

    // public function all_user_salary_select(){
    //   $userss = User::orderBy('id','DESC')->where('type_id','2')->where('is_active','1')->select('id','name','user_code')->whereHas('getSalaryUser', function($q){
    //     $q->where('is_salary',True);
    // })->get();
    //     return response()->json([
    //         'userSalarySelect'=>$userss
    //     ],200);
    // }
}