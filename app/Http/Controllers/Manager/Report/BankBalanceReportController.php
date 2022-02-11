<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BankBalance;
use App\IncomeExpense;
use App\Order_detail;
use App\ChecKInHasRoom;
use Auth;
use Response;
use App\Stock;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Manager\BankBalanceExport;
use Illuminate\Database\Eloquent\Builder;


class BankBalanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = BankBalance::orderBy('id','DESC');
        if((!empty($request->date1)) || (!empty($request->date2)))
        {
            $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
        }
        $total = $posts->sum('amount');
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
           'bankbalancereports' => $posts,
           'total' => $total,
       ];
       return response()->json($response);
    }

    public function totalbankbalance(Request $request,$date1,$date2)
    {
        // dd($date1,$date2);
        $totalbankbalance = BankBalance::where('created_by',Auth::user()->id);
        $purchase_expense = Stock::where('created_by', Auth::user()->id);
        $expenditure = IncomeExpense::where('type','2');
        $income = IncomeExpense::where('type','1')->where('topic_id','!=','1');
        $restaurant_sales = Order_detail::where('restaurant_hotel_type','0');
        $hotel_sales = Order_detail::where('restaurant_hotel_type','1');
        $hotel_checkout = ChecKInHasRoom::whereHas('getCheckIn', function(Builder $query){
                              $query->where('is_check_out', '1');
                            });
        if((!empty($date1)) || (!empty($date2)))
        {
            $totalbankbalance = $totalbankbalance->whereBetween('date', [$date1, $date2]);
            $purchase_expense = $purchase_expense->whereBetween('date', [$date1, $date2]);
            $expenditure = $expenditure->whereBetween('date', [$date1, $date2]);
            $income = $income->whereBetween('date', [$date1, $date2]);
            $restaurant_sales = $restaurant_sales->whereBetween('date', [$date1, $date2]);
            $hotel_sales = $hotel_sales->whereBetween('date', [$date1, $date2]);
            $hotel_checkout = $hotel_checkout->whereHas('getCheckIn', function(Builder $query) use ($date1,$date2){
                              $query->whereBetween('date', [$date1, $date2]);
                            });

        }
        $totalbankbalance = $totalbankbalance->sum('amount');
        $purchase_expense = $purchase_expense->sum('price');
        $expenditure = $expenditure->sum('amount');
        $income = $income->sum('amount');
        $restaurant_sales = $restaurant_sales->sum('tender');
        $hotel_sales = $hotel_sales->sum('tender');
        $hotel_checkout = $hotel_checkout->with('getRoom','getCheckIn')->get();
        $response = [
           'totalbankbalance' => $totalbankbalance,
           'purchase_expense' => $purchase_expense,
           'expenditure' => $expenditure,
           'income' => $income,
           'restaurant_sales' => $restaurant_sales,
           'hotel_sales' => $hotel_sales,
           'hotel_checkout' => $hotel_checkout,
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
        //
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
        //
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
        //
    }

    public function fileExport(Request $request)
    {
        $current_date = date("Y-m-d");
        $filename = 'bankbalanceReport'.$current_date.'.xlsx';
        return Excel::download(new BankBalanceExport($request->start_date, $request->end_date), $filename);

    }
}
