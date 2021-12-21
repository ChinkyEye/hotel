<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Usertype;
use Auth;
use Illuminate\Support\Facades\Hash;

class KitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = User::orderBy('id','DESC')->where('user_type','6')->where('type_id','0');
        if(empty($request->search))
          {            
            $posts = $posts;
          }
        else{
              $search = $request->search;
              $posts = $posts->where('name', 'LIKE',"%{$search}%");
          }
          $posts = $posts->where('user_type','6')->where('type_id','0')->paginate(15);
          $response = [
             'pagination' => [
                 'total' => $posts->total(),
                 'per_page' => $posts->perPage(),
                 'current_page' => $posts->currentPage(),
                 'last_page' => $posts->lastPage(),
                 'from' => $posts->firstItem(),
                 'to' => $posts->lastItem()
             ],
             'kitchens' => $posts
         ];
         return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $user_type = Usertype::where('level_id','6')->where('is_active','1')->value('id');
        return User::create([
           'name' => $request['name'],
           'user_code' => strtotime("now"),
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'phone' => $request['phone'],
           'address' => $request['address'],
           'is_active' => '1',
           'user_type' => '6',
           'type_id' => '0',
           'user_type_id' => $user_type,
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kitchens = User::findOrFail($id);
        return response()->json([
            'kitchens'=>$kitchens
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usertype = User::findOrFail($id);
        $usertype->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $user = User::findOrFail($id);
        $user->is_active = !$avi;
        $user->save();
    }
}
