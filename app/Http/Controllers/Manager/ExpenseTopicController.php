<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IncomeExpenseTopic;
use Auth;

class ExpenseTopicController extends Controller
{
    public function index(Request $request){
      $posts = IncomeExpenseTopic::where('type',2)->orderBy('id','DESC');
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
           'expensetopics' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);

        return IncomeExpenseTopic::create([
           'name' => $request['name'],
           'type' => '2',
           'slug' => strtolower($request['name']),
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $units = IncomeExpenseTopic::findOrFail($id);
        return response()->json([
            'units'=>$units
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $units = IncomeExpenseTopic::findOrFail($id);
        $units->update($request->all());
    }

     public function destroy($id){
        $units = IncomeExpenseTopic::findOrFail($id);
        $units->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $units = IncomeExpenseTopic::findOrFail($id);
        $units->is_active = !$avi;
        $units->save();
    }

    public function all_expensetopic_select(){
        $unitSelect = IncomeExpenseTopic::where('type',2)->orderBy('id','DESC')->where('is_active','1')->select('id','name')->get();
        return response()->json([
            'expensetopicSelect'=>$unitSelect
        ],200);
    }
}
