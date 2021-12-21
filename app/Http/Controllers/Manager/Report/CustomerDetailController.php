<?php

namespace App\Http\Controllers\Manager\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order_detail;
use App\User;
use Auth;

use App\Exports\Manager\CustomerReportExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerDetailController extends Controller
{
  public function index(Request $request){
    // var_dump("expression"); die();
      $posts = Order_detail::orderBy('id','DESC')->where('is_confirmed','1')
      // ->where('created_by',Auth::user()->id)
      ->where('customer_id',$request->user_id);
      if(($request->has('date1')) || ($request->has('date2')))
      {
        $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
      }
      if($request->has('receive_type') && ($request->get('receive_type') != ''))
      {
        $posts = $posts->where('receive_type',$request->receive_type);
      }
      if(($request->get('receive_type')==0 || $request->get('receive_type')=='') && ($request->has('bill_type') && $request->get('bill_type')!=""))
      {
        $posts = $posts->where('bill_type',$request->bill_type);
      }
      $total = $posts->sum('total');
      $discount = $posts->sum('discount');
      $grand_total = $posts->sum('grand_total');
      $received = $posts->sum('received');

      $posts = $posts->with('table')->withCount('count')->paginate(15);
      $response = [
         'pagination' => [
             'total' => $posts->total(),
             'per_page' => $posts->perPage(),
             'current_page' => $posts->currentPage(),
             'last_page' => $posts->lastPage(),
             'from' => $posts->firstItem(),
             'to' => $posts->lastItem()
         ],
         'userordersummarydetails' => $posts,
         'total' => $total,
         'discount' => $discount,
         'grand_total' => $grand_total,
         'received' => $received,
     ];
     return response()->json($response);
  }

  public function store(Request $request)
    {   
      // dd($request);
      $this->validate($request, [
            'user_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        $current_date = date("Y-m-d",strtotime($request->date));
        $current_time = date("H:i:s");
        $auth = Auth::user()->id;
        $bill_id = strtotime(date(("Y-m-d H:i:s")));
        $user_t_id = User::where('id',$request->user_id)->value('user_type_id');

        $order_total = new Order_detail;
        $order_total->bill_id = $bill_id;
        $order_total->billed_by = Auth::user()->id;
        $order_total->total = '0';
        $order_total->discount = '0';
        $order_total->grand_total = '0';
        $order_total->customer_id = $request->user_id;
        $order_total->table_id = '1';
        $order_total->usertype_id = $user_t_id;
        $order_total->date = $current_date;
        $order_total->date_np = $this->helper->date_np_con_parm($current_date);
        $order_total->time = $current_time;
        $order_total->received = $request->amount;
        $order_total->is_active = '1';
        $order_total->is_confirmed = '1';
        $order_total->bill_type = '2';
        $order_total->receive_type = '1';
        $order_total->created_by = $auth;
        $order_total->save();
        
        return response()->json([
            'message'=>'ok',
            'bill_id' => $bill_id
        ],200);
    }

    public function fileExport(Request $request) 
    {
      $filename = 'customerReport.xlsx';
      return Excel::download(new CustomerReportExport($request->user_id, $request->receive_type,$request->bill_type, $request->start_date, $request->end_date), $filename);
    }
}