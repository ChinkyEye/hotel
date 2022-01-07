<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\ChecKInHasRoom;
use App\CheckIn;
use App\Order_detail;
use App\Room;
use Carbon\Carbon;
use Auth;

class CheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = CheckIn::orderBy('id','DESC')->where('created_by', Auth::user()->id);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('room_type', 'LIKE',"%{$search}%");
        }
        // $posts = $posts->paginate(15);
        $posts = $posts->with('getUser','getCheckInRoom')->paginate(15);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'checkins' => $posts
        ];
        return response()->json($response);
    }

    public function all_customer_select()
    {
        $customerSelects = User::orderBy('id','DESC')
                                ->where('is_active','1')
                                ->where('user_type','0')
                                ->where('type_id','2')
                                // ->where('user_type_id','10')
                                ->select('id','name','user_code')
                                ->get();
        return response()->json([
            'customerSelects'=>$customerSelects
        ],200);
    }

    public function all_customer_check(Request $request)
    {
        $checkin_id = $request->checkin_id;
        // dd($checkin_id);
        $user_id = CheckIn::where('id',$checkin_id)->value('user_id');
        $check_out_date = CheckIn::where('user_id',$user_id)->value('check_out_date');

        $check_in_date = CheckIn::where('id',$checkin_id)->value('check_in_date');
        $check_out_date = CheckIn::where('id',$checkin_id)->value('check_out_date');
        $interval   = Carbon::parse($check_in_date)->diffInDays(Carbon::parse($check_out_date));

        $room_price = CheckIn::where('id',$checkin_id)
                                ->where('is_active','1')
                                ->with('getCheckInRoom')
                                ->get();
        $array = [];
        foreach($room_price as $key => $value){
            foreach($value->getCheckInRoom as $key => $data ){
                $array[] = $data->getRoom->price;
            }
        } 
        $grand_total = Order_detail::where('customer_id',$user_id)
                                    ->where('date','<=',$check_out_date)
                                    ->pluck('grand_total');
        $tender = Order_detail::where('customer_id',$user_id)
                                ->where('date','<=',$check_out_date)
                                ->pluck('tender');

        $arr_length = sizeof($grand_total) - 1;
        $minus_arr = [];
        for($i = 0; $i <= $arr_length; $i++){
            $minus = $grand_total[$i] - $tender[$i];
            array_push($minus_arr, $minus);
        }
        $remaining_total = array_sum($minus_arr);
        // dd($remaining_total);

        $status = CheckIn::where('id',$checkin_id)->value('is_check_out');
        // dd($status);

        $sum = array_sum($array) * $interval;
        $grand_sum = $sum + $remaining_total;  

       
        $posts = Order_detail::where('customer_id',$user_id)
                                ->where('receive_type','0')
                                ->where('date','<=',$check_out_date)
                                ->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'customerorderdetails' => $posts,
           'day_of_stay' => $interval,
           'room_price' => $room_price,
           'sum' => $sum,
           // 'due' => $minus_arr,
           'remaining_total' => $remaining_total,
           'grand_sum' => $grand_sum,
           'user_id' => $user_id,
           'status' => $status,
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
        // dd($request);
        $checkins = CheckIn::create([
            'user_id' => $request['user_id'],
            'check_in_date' => $request['date1'],
            'check_out_date' => $request['date2'],
            'document_type' => $request['document_type'],
            'is_active' => '1',
            'date' => date("Y-m-d"),
            'date_np' => $this->helper->date_np_con(),
            'time' => date("H:i:s"),
            'created_by' => Auth::user()->id,
        ]);
        $loop_check = $request->room_id;
        foreach ($loop_check as $key => $value) {
            $checkinrooms = ChecKInHasRoom::create([
                'checkin_id' => $checkins->id,
                'room_id' => $value,
                'is_active' => '1',
                'date' => date("Y-m-d"),
                'date_np' => $this->helper->date_np_con(),
                'time' => date("H:i:s"),
                'created_by' => Auth::user()->id,
            ]);

            $rooms = Room::findOrFail($value);
            $rooms->is_available = '0';
            $rooms->update();

        }
        // return ['message' => 'Data Created'];
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
        // dd($id);
        $checkins = CheckIn::with('getUser')->findOrFail($id);
        return response()->json([
            'checkins'=>$checkins
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkins = CheckIn::findOrFail($id);
        $checkins->delete();
        return ['message'=>'ok'];
    }
    public function checkout(Request $request)
    {
        $checkins = CheckIn::findOrFail($request->checkin_id);
        $checkins->check_out_date = $request->date2;
        $checkins->update();

    }

    public function savedetail(Request $request)
    {
        // dd($request);
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $auth = Auth::user()->id;
        $bill_id = strtotime(date(("Y-m-d H:i:s")));
        $user_t_id = User::where('id',$request->id)->value('user_type_id');
        $checkin_id = CheckIn::where('user_id',$request->id)->where('is_check_out','0')->value('id');
        // dd($checkin_id);
        // dd($request,$user_t_id,$checkin_id);
        if($request->total != 0){
            $order_total = new Order_detail;
            $order_total->bill_id = $bill_id;
            $order_total->billed_by = Auth::user()->id;
            $order_total->total = '0';
            $order_total->discount = '0';
            $order_total->grand_total = '0';
            $order_total->customer_id = $request->id;
            $order_total->table_id = '1';
            $order_total->usertype_id = $user_t_id;
            $order_total->date = $current_date;
            $order_total->date_np = $this->helper->date_np_con_parm($current_date);
            $order_total->time = $current_time;
            $order_total->received = $request->total;
            $order_total->is_active = '1';
            $order_total->is_confirmed = '1';
            $order_total->bill_type = '2';
            $order_total->receive_type = '1';
            $order_total->created_by = $auth;
            $order_total->save();
        }
        
        $checkins = CheckIn::findOrFail($checkin_id);
        $checkins->is_check_out = '1';
        $checkins->update();

         return ['message' => 'Data Created'];
        // return response()->json([
        //     'message'=>'ok',
        //     'bill_id' => $bill_id
        // ],200);
    }

    public function status($id, $avi){
     $checkins = CheckIn::findOrFail($id);
     $checkins->is_active = !$avi;
     $checkins->save();
   }
}
