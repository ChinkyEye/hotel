<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Rules\MatchOldPassword;
use App\Rules\PasswordField;
use Illuminate\Support\Facades\Hash;
use Validator;
Use Exception;


class HomeController extends Controller
{
    public function login(Request $request)
    {
        
        $email = $request->email;
        $password = $request->password;
        if(Auth::attempt(['email'=>$email,'password'=>$password], true)){ //is_active->1 wala hatae diye
            return response()->json(['success'=>true,'message'=>'Successfully logged in','user_type'=>Auth::user()->user_type,'user'=>Auth::user()]);
        }
        else{
           return response()->json(['success'=>false,'message'=>'Invalid username or password']);
        }
    }

    //change password
public function change_password(PasswordField $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_password_confirmation' => ['same:new_password'],
        ]);
        if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
            }
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        Auth::logout();
        return response()->json([['success'=>true,'message'=>'Password Changed']]);
    }


}
