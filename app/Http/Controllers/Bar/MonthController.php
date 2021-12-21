<?php

namespace App\Http\Controllers\Bar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Month;
use Auth;

class MonthController extends Controller
{
    public function index(){
        $months = Month::select('id','name')->get();
        return response()->json([
            'months'=>$months
        ],200);
    }
}