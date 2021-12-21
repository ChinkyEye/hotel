<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\FiscalYear;
use Auth;
use Response;

class FiscalYearController extends Controller
{
    public function index()
    {
        // dd("bitch");
        $posts = FiscalYear::orderBy('id','DESC');
        $posts = $posts->paginate(30);
        $response = [
            'pagination' => [
              'total' => $posts->total(),
              'per_page' => $posts->perPage(),
              'current_page' => $posts->currentPage(),
              'last_page' => $posts->lastPage(),
              'from' => $posts->firstItem(),
              'to' => $posts->lastItem()
          ],
          'fiscalyears' => $posts
        ];
        return response()->json($response);
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        if($request['date_np'] == null)
        {
            $request['date_np'] = $this->helper->date_np_con(); 

        }
        else{
            $request['date_np'] = $this->helper->date_np_con_parm($request['date_np']);
        }
        FiscalYear::create([
            'name' => $request['name'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'date_np' => $request['date_np'],
            'time_np' => date("H:i:s"),
            'is_active' => '1',
            'created_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Created'];
    }

    public function edit($id)
    {
        $fiscals = FiscalYear::findOrFail($id);
        return response()->json([
            'fiscals'=>$fiscals
        ],200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = FiscalYear::findOrFail($id);

        $user->update([
            'name' => $request['name'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'time_np' => date("H:i:s"),
            'updated_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Updated'];
    }

    public function destroy($id)
    {
        $usertype = FiscalYear::findOrFail($id);
        $usertype->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
      $user = FiscalYear::findOrFail($id);
      $user->is_active = !$avi;
      $user->save();
    }

    public function getAllFiscalYear(Request $request){
        $fiscalyears = FiscalYear::orderBy('name','ASC')->where('is_active','1')->get();
        // dd($fiscalyears);
        return response()->json([
          'selectfiscalyears'=>$fiscalyears
        ],200);

    }
}
