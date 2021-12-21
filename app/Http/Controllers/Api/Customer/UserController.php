<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Usertype;
use App\Rules\PasswordField;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;


class UserController extends Controller
{
    
    public function register(Request $request)
    {   

      // dd("correct");
        
          $user = new User;
          $user->name = $request->name;
          $user->user_code = strtotime("now");
          $user->email = $request->email;
          $user->password = Hash::make($request['password']);
          $user->phone = $request->phone;
          $user->address = $request->address;
          $user->is_active ='1';
          $user->user_type ='7';
          $user->type_id = '2';
          $user->user_type_id = '7';
          $user->date = date("Y-m-d");
          $user->date_np =$this->helper->date_np_con();
          $user->time = date("H:i:s");
          // var_dump($request->name,$request->class);
          $user->save();


              return response()->json([[
              "message" => "user record created"
          ]], 201);
    }

}