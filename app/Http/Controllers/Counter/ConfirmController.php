<?php

namespace App\Http\Controllers\Counter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Table;
use App\Item;
use App\Order;
use App\User;
use App\Order_detail;
use App\Usertype;
use App\Bill_has_sn;
use Auth;
use App\Configure;
use App\IncomeExpenseTopic;
use App\IncomeExpense;

class ConfirmController extends Controller
{
    public function index(Request $request){
        $posts = Order_detail::orderBy('id','DESC');
        if(!empty($request->search))
            {            
                $posts = $posts->where('bill_id', 'LIKE',"%{$request->search}%");
            }
        if(!empty($request->user_type))
          {
            $posts = $posts->where('usertype_id','LIKE',"%{$request->user_type}%");
          }
        if(!empty($request->table_id))
          {
            $posts = $posts->where('table_id',$request->table_id);
          }
        if(!empty($request->date))
          {
            $posts = $posts->where('date', $request->date);
          }
        $posts = $posts->with('customer','usertype','table','createdUser')->withCount('count')->where('is_confirmed','0')->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'orderdetails' => $posts
       ];
       return response()->json($response);
    }

    public function show($id){
        $notconfirmbills = Order_detail::where('id', $id)->with('order','customer','usertype')->first();
        return response()->json([
            'notconfirmbills'=>$notconfirmbills
        ],200);
    }

    public function store(Request $request)
    {   
        // dd($request->tender,$request->change,$request->remaining);
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $auth = Auth::user()->id;
        $user_id = $request->user_id;
        $user_type_id = User::where('id',$user_id)->value('user_type_id');

        $calc_gtotal = 0;
        $cal_discount = 0;
        $req_disc = 0;
        $req_total = 0;
        $loop_check = $request->data;
        foreach ($loop_check as $key => $value) {
            $calc_value = Item::where('id', $value['item_id'])->get();
            $bill_id = $request->bill_id;
            foreach ($calc_value as $index => $calc_values) {
                $calc_item_id = $calc_values->id;
                $calc_unit_id = $calc_values->unit_id;
                $calc_rate = $calc_values->price;
                $calc_cat_id = $calc_values->category_id;
                $calc_mg = 0;
                $calc_weight = 0;
                $calc_discount = 0;
                $update_count = Order::where('bill_id', $bill_id)->where('item_id', $value['item_id'])->count();
                if($update_count){
                    $order_id = Order::where('bill_id', $bill_id)->where('item_id', $value['item_id'])->value('id');
                    $orderupdate = Order::find($order_id);
                    $orderupdate->quantity = $value['quantity'];
                    $ca_discount = $value['quantity']*($calc_discount);
                    $cal_tot = $value['quantity']*($calc_rate - $calc_discount);
                    $orderupdate->total = $cal_tot;
                    $orderupdate->date = $current_date;
                    $orderupdate->date_np = $this->helper->date_np_con();
                    $orderupdate->time = $current_time;
                    $orderupdate->is_confirmed = '1';
                    $orderupdate->customer_id = $user_id;
                    $orderupdate->usertype_id = $user_type_id;
                    $orderupdate->save();


                    $item = Item::find($calc_item_id);
                    $item->qty_rem = $item->qty_rem - $value['quantity'];
                    $item->save();
                }
                else{
                    $order = new Order();
                    $cid = Order::where('bill_id', $bill_id)->value('customer_id');
                    $uid = Order::where('bill_id', $bill_id)->value('usertype_id');
                    $order->customer_id = $cid;
                    $order->usertype_id = $uid;
                    $order->bill_id = $bill_id;
                    $order->item_id = $calc_item_id;
                    $order->unit_id = $calc_unit_id;
                    $order->category_id = $calc_cat_id;
                    $order->quantity = $value['quantity'];
                    $ca_discount = $value['quantity']*($calc_discount);
                    $cal_tot = $value['quantity']*($calc_rate - $calc_discount);
                    $order->total = $cal_tot;
                    $order->date = $current_date;
                    $order->date_np =  $this->helper->date_np_con();
                    $order->time = $current_time;
                    $order->is_confirmed = '1';
                    $order->customer_id = $user_id;
                    $order->is_active = '1';
                    $order->bill_type = '1';
                    $order->created_by = $auth;
                    $order->billed_by = $auth;
                    $order->save();
                }
            }
                $calc_gtotal += $cal_tot;
                $cal_discount += $ca_discount;
            }

            $receive = $request->tender;
            $getDefineDiscount = Usertype::where('id',$user_type_id)->value('discount');
            $detail_id = Order_detail::where('bill_id', $bill_id)->value('id');
            $req_total = $calc_gtotal;
            $req_disc = $cal_discount + ($req_total*$getDefineDiscount/100);
            $order_total = Order_detail::find($detail_id);
            $order_total->bill_id = $bill_id;
            $order_total->total = $calc_gtotal;
            $order_total->discount = $req_disc;
            $order_total->grand_total = $req_total - $req_disc;
            $order_total->tender = $request->tender;
            $order_total->return_change = $request->change;
            // $order_total->received = $request->remaining;
            $order_total->received = $receive;
            $order_total->date = $current_date;
            $order_total->date_np = $this->helper->date_np_con();
            $order_total->date = $current_date;
            $order_total->is_active = '1';
            $order_total->is_confirmed = '1';
            $order_total->customer_id = $user_id;
            $order_total->usertype_id = $user_type_id;
            // dd($calc_gtotal,$receive);
            if($calc_gtotal == $receive){
                $bill_type = '0'; // paid
            }
            else{
                $bill_type = '1'; // due
            }

            // if($calc_gtotal == $receive){
            //       $bill_type = '0'; // paid
            // }
            // else{
            //      $bill_type = '1'; // due
            // }
            $order_total->bill_type = $bill_type;
            $order_total->billed_by = $auth;
            $order_total->save();

            $configure = Configure::where('is_active',1)->first();
            // dd($configure->income_receiveamount,$configure);

            if($configure->income_bill == 1){
            

              $incometopic = IncomeExpenseTopic::firstOrCreate([
                  'name' => 'Bill'
              ], [
                  'name' => 'Bill',
                  'type' => '1',
                  'slug' => strtolower('Bill'),
                  'is_active' => '1',
                  'date' => date("Y-m-d"),
                  'date_np' => $this->helper->date_np_con(),
                  'time' => date("H:i:s"),
                  'created_by' => Auth::user()->id,
              ]);
              $incomeexpense_id = IncomeExpenseTopic::where('name','Bill')->value('id');


              $incomeexpense = IncomeExpense::create([
                 'topic_id' => $incomeexpense_id,
                 'description' => 'Bill details',
                 'amount' => $calc_gtotal,
                 'iedate' => $this->helper->date_np_con(),
                 'type' => '1',
                 'is_active' => '1',
                 'date' => date("Y-m-d"),
                 'date_np' => $this->helper->date_np_con(),
                 'time' => date("H:i:s"),
                 'created_by' => Auth::user()->id,
              ]);
            }
            


            $bill_sn = new Bill_has_sn();
            $bill_count = Bill_has_sn::count();
            $bill_sn->bill_sn = $bill_count+1;
            $bill_print_count = Bill_has_sn::where('bill_id', $bill_id)->count();
            $bill_sn->is_print = 0;
            $bill_sn->print_count = 0;
            $bill_sn->bill_id = $bill_id;
            $bill_sn->date = $current_date;
            $bill_sn->date_np = $this->helper->date_np_con();
            $bill_sn->time = $current_time;
            $bill_sn->created_by = $auth;
            $bill_sn->save();

        
        return response()->json([
            'message'=>'ok',
            'bill_id' => $bill_id
        ],200);
    }

    public function bill($bill){
        $bills = Order_detail::where('bill_id', $bill)->with('order','customer','table','usertype','createdUser','allbill')->first();
        return response()->json([
            'bills'=>$bills
        ],200);
    }

    public function destroy($id){
        $orders = Order::findOrFail($id);
        $orders->delete();
        return ['message'=>'ok'];
    }

    public function status($id){
        $user = Order_detail::findOrFail($id);
        $user->is_active = '0';
        $user->save();
        $bill_id = Order_detail::where('id',$id)->value('bill_id');
        $ord = Order::where('bill_id',$bill_id)->update(['is_active'=>'0']);
    }

    public function printStatus($billid){
        // var_dump($billid);
        $id = Bill_has_sn::where('bill_id',$billid)->value('id');
        $bill_sn = Bill_has_sn::find($id);
        $bill_print_count = Bill_has_sn::where('bill_id', $billid)->value('print_count');
        // var_dump($bill_print_count);
        $bill_sn->is_print = 1;
        $bill_sn->print_count = $bill_print_count+1;
        $bill_sn->save();
    }
}