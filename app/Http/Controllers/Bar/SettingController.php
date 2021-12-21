<?php

namespace App\Http\Controllers\Bar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Auth;

class SettingController extends Controller
{
   public function billsetting(Request $request){
     $posts = Setting::orderBy('id','DESC')->first();
     $response = [
       'settings' => $posts
     ];
     return response()->json($response);
   }
}