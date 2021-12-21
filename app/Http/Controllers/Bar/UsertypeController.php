<?php

namespace App\Http\Controllers\Bar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usertype;

class UsertypeController extends Controller
{
    public function index(Request $request){
        $totalData = Usertype::orderBy('id','asc')->where('type_id','!=','0')->count();
        $totalFiltered = $totalData;
        $limit = 10;
        $start = intval($request->page) * $limit;
        $order = 'created_at';
        $dir = 'DESC';

        if(empty($request->search))
        {            
            $usertype = Usertype::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir);
        }
        else {
            $search = $request->search;
            $usertype =  Usertype::where('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir);
            $totalData = Usertype::orderBy('id','asc')->where('name', 'LIKE',"%{$search}%")->where('is_active','1')->count();
            $totalFiltered = $totalData;
        }
        $usertypes = $usertype->orderBy('id','desc')->where('type_id','!=','0')->get();
        return response()->json([
            'usertypes'=>$usertypes,
            'totalFiltered' => $totalFiltered,
            'totalData' => $totalData,
            'pages' => ($totalData > 0)?(intval(($totalData-1)/$limit) + 1):0,
        ],200);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required',
            'type_id' => 'required',
        ]);

        return Usertype::create([
           'name' => $request['name'],
           'slug' => $request['name'],
           'type_id' => $request['type_id'],
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'is_active' => '1',
        ]);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = Usertype::findOrFail($id);
        $user->update($request->all());
    }

    public function delete($id){
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

    public function all_usertype_select(){
        $usertypes = Usertype::orderBy('id','DESC')->where('type_id','!=','0')->where('is_active','1')->select('id','name','type_id')->withCount('getCountUser')->get();
        return response()->json([
            'usertypeSelect'=>$usertypes
        ],200);
    }

    public function all_sellerusertype_select(){
        $usertypes = Usertype::orderBy('id','DESC')->where('type_id','!=','0')->where('type_id','!=','1')->where('is_active','1')->select('id','name','discount')->get();
        return response()->json([
            'sellerusertypeSelect'=>$usertypes
        ],200);
    }
}