<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Canteen_package;
use App\User_has_package;
use Auth;

class PackageController extends Controller
{
    public function index(Request $request){
      $posts = Canteen_package::orderBy('id','DESC');
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'packages' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {  
        $this->validate($request, [
            'name' => 'required',
            'rate' => 'required',
        ]);

        return Canteen_package::create([
           'name' => $request['name'],
           'slug' => str_replace(' ', '-', strtolower($request['name'])).'-'.rand(1000,9999),
           'rate' => $request['rate'],
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $packages = Canteen_package::findOrFail($id);
        return response()->json([
            'packages'=>$packages
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
            'rate' => 'required',
        ]);
        $user = Canteen_package::findOrFail($id);
        $user->update($request->all());
    }

     public function destroy($id){
        $package = Canteen_package::findOrFail($id);
        $package->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $user = Canteen_package::findOrFail($id);
        $user->is_active = !$avi;
        $user->save();
    }

    public function all_package_select(){
        $packages = Canteen_package::orderBy('id','DESC')->where('is_active','1')->select('id','name','days')->get();
        return response()->json([
            'packageSelect'=>$packages
        ],200);
    }

    public function special_user_package_select(){
        $userss = User_has_package::with('getUserPackage')->orderBy('id','DESC')->where('user_id',request('user'))->get();
        // $userss = Canteen_package::where('id', $canteen_package_id)->value('name');
        return response()->json([
            'spcialuserpackage'=>$userss
        ],200);
    }
}