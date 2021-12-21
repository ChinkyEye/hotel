<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IncomeExpense;
use Auth;
use Illuminate\Database\Eloquent\Builder;

class ExpenseController extends Controller
{
    public function index(Request $request){
      $posts = IncomeExpense::where('type',2)->where('created_by',Auth::user()->id)->orderBy('id','DESC');
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            // $posts = $posts->where('name', 'LIKE',"%{$search}%");
            $posts = $posts->whereHas('getTopic', function($q) use($search){
                           $q->where('name', 'LIKE',"%{$search}%");
                        });

        }
        $posts = $posts->with('getTopic')->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'expenses' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'topic_id' => 'required',
        ]);

        return IncomeExpense::create([
           'topic_id' => $request['topic_id'],
           'description' => $request['description'],
           'amount' => $request['amount'],
           'iedate' => $request['date'],
           'type' => '2',
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $units = IncomeExpense::findOrFail($id);
        return response()->json([
            'units'=>$units
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'topic_id' => 'required',
        ]);
        $units = IncomeExpense::findOrFail($id);
        $units->update($request->all());
    }

     public function destroy($id){
        $units = IncomeExpense::findOrFail($id);
        $units->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $units = IncomeExpense::findOrFail($id);
        $units->is_active = !$avi;
        $units->save();
    }
}
