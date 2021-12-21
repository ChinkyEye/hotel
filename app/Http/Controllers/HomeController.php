<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Category;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.main');
    }

    public function menu()
    {
        // $items = Item::orderBy('id','DESC')->get();
        $categories = Category::orderBy('id','DESC')->get();
        // dd($categories);
        return view('menu',compact('categories'));
    }
}
