<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usertype;
use App\User;
use App\Category;
use App\Canteen_package;
use App\Unit;
use App\Stock;
use App\Table;
use App\Item;
use App\Order;
use App\Order_detail;
use App\Salary;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('manager.main');
    }

    public function loadDashboard(Request $request){
      $current_date = date("Y-m-d");
    	$usertype_count = Usertype::where('type_id','!=','0')->count();
    	$user_count = User::where('user_type','0')->count();
    	$category_count = Category::where('is_active','1')->count();
    	$package_count = Canteen_package::where('is_active','1')->count();
    	$unit_count = Unit::where('is_active','1')->count();
    	$stock_count = Stock::where('is_active','1')->count();
    	$table_count = Table::where('is_active','1')->count();
    	$item_count = Item::where('is_active','1')->count();
    	$order_count = Order_detail::where('is_confirmed','0')->where('date',$current_date)->count();
    	$confirm_order_count = Order_detail::where('is_confirmed','1')->where('date',$current_date)->count();
        $response = [
           'usertype_count' => $usertype_count,
           'user_count' => $user_count,
           'category_count' => $category_count,
           'package_count' => $package_count,
           'unit_count' => $unit_count,
           'stock_count' => $stock_count,
           'table_count' => $table_count,
           'item_count' => $item_count,
           'order_count' => $order_count,
           'confirm_order_count' => $confirm_order_count,
       ];
       return response()->json($response);
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_password_confirmation' => ['same:new_password'],
        ]);
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        Auth::logout();
        return ['message'=>'OK'];
    }
}