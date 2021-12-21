<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User_has_package;
use Auth;

class UserPackageController extends Controller
{
	public function store(Request $request)
    {   
        $this->validate($request, [
            'package_id' => 'required',
            'user_id' => 'required',
            'fdate' => 'required',
        ]);
        $getSal = User_has_package::where('user_id', $request['user_id'])->count();
        if($getSal){
          $id = User_has_package::where('user_id', $request['user_id'])->value('id');
          $usal = User_has_package::find($id);
          $usal->canteen_package_id = $request['package_id'];
          $usal->effective = $request['fdate'];
          $usal->save();
        }
        else{
          return User_has_package::create([
             'canteen_package_id' => $request['package_id'],
             'user_id' => $request['user_id'],
             'effective' => $request['fdate'],
             'date' => date("Y-m-d"),
             'date_np' => $this->helper->date_np_con(),
             'time' => date("H:i:s"),
             'created_by' => Auth::user()->id,
          ]);
        }
    }
}