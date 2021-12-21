<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Usertype;
use Auth;

class CustomerSellerController extends Controller
{
     public function index(Request $request){
        $posts = Usertype::where('type_id','2')->orderBy('id','DESC')->where('created_by', Auth::user()->id);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else {
            $search = $request->search;
            $posts =  $posts->where('name', 'LIKE',"%{$search}%");
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
           'sellertypes' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);

        return Usertype::create([
           'name' => $request['name'],
           'slug' => $request['name'],
           'discount' => $request['discount'],
           'type_id' => '2',
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $categories = Usertype::findOrFail($id);
        return response()->json([
            'categories'=>$categories
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = Usertype::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy($id){
        $usertype = Usertype::findOrFail($id);
        $usertype->delete();
        return ['message'=>'ok'];
    }


    public function status($id, $avi){
        $user = Usertype::findOrFail($id);
        $user->is_active = !$avi;
        $user->save();
    }

    public function salary($id, $avi){
        $user = Usertype::findOrFail($id);
        $user->is_salary = !$avi;
        $user->save();
    }
}
