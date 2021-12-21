<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User_has_salary;
use Auth;

class UserSalaryController extends Controller
{
	public function store(Request $request)
    {   
        $this->validate($request, [
            'user_id' => 'required',
            'salary' => 'required',
        ]);
        $getSal = User_has_salary::where('user_id', $request['user_id'])->count();
        if($getSal){
          $id = User_has_salary::where('user_id', $request['user_id'])->value('id');
          $usal = User_has_salary::find($id);
          $usal->salary = $request['salary'];
          $usal->save();
        }
        else{
        return User_has_salary::create([
           'salary' => $request['salary'],
           'user_id' => $request['user_id'],
           'created_by' => Auth::user()->id,
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
        ]);
        }
    }
}