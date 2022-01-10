<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BankBalance;
use Auth;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Manager\BankBalanceExport;


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
