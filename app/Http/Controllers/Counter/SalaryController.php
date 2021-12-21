<?php

namespace App\Http\Controllers\Counter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Salary;
use App\User_has_salary;
use Auth;

class SalaryController extends Controller
{
    public function index(Request $request){
      $posts = Salary::orderBy('id','DESC')->with('user','month');
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('user_id','LIKE',"%{$search}%");
        }
      if(empty($request->month_id))
      {
        $posts = $posts;
      }
      else{
        $month_id = $request->month_id;
        $posts = $posts->where('month_id','LIKE',"%{$month_id}%");
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
           'salaries' => $posts
       ];
       return response()->json($response);
    }

    public function show($id){
      $posts = Salary::orderBy('id','DESC')->where('user_id', $id)->with('user','month')->get();
      $salary = User_has_salary::where('user_id',$id)->value('salary');
      $advance = Salary::where('user_id',$id)->where('type','0')->sum('total');
      $deduct = Salary::where('user_id',$id)->where('type','2')->sum('total');
      $new_adc = $advance-$deduct;
        $response = [
           'salaries' => $posts,
           'usersalary' => $salary,
           'deduct' => $new_adc,
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'user_id' => 'required',
            'month_id' => 'required',
            'amount' => 'required',
            'vat' => 'required',
            'total' => 'required',
        ]);

        return Salary::create([
           'user_id' => $request['user_id'],
           'month_id' => $request['month_id'],
           'amount' => $request['amount'],
           'vat' => $request['vat'],
           'total' => $request['total'],
           'type' => $request['type'],
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function bill($bill){
        $bills = Order_detail::where('bill_id', $bill)->with('order','customer')->first();
        return response()->json([
            'bills'=>$bills
        ],200);
    }

    public function edit($id){
        $tables = Salary::findOrFail($id);
        return response()->json([
            'tables'=>$tables
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $tables = Salary::findOrFail($id);
        $tables->update($request->all());
    }

     public function destroy($id){
        $tables = Salary::findOrFail($id);
        $tables->delete();
        return ['message'=>'ok'];
    }

    public function special_user_salary_select(){
        $userss = User_has_salary::orderBy('id','DESC')->where('user_id',request('user'))->value('salary');
        $advance = Salary::where('user_id',request('user'))->where('type','0')->sum('total');
        $response = [
           'spcialusersalary' => $userss,
           'spcialuseradvance' => $advance
       ];
        return response()->json($response,200);
    }
}