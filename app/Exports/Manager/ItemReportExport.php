<?php

namespace App\Exports\Manager;

use App\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth;
use DB;

class ItemReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $category_id = NULL;
    private $item_id = NULL;
    private $start_date = NULL;
    private $end_date = NULL;
    public function __construct($category_id, $item_id, $start_date, $end_date)
	{
		if($category_id!="") $this->category_id = $category_id;
		if($item_id!="") $this->item_id = $item_id;
		if($start_date!="") $this->start_date = $start_date;
		if($end_date!="") $this->end_date = $end_date;
	}
    public function view(): View
    {
	    $orders = Order::orderBy('id','DESC')->where('created_by',Auth::user()->id);
	    if($this->category_id != NULL)
	      {            
	        $orders = $orders->where('category_id', $this->category_id);
	      }
	    if($this->item_id != NULL)
	      {
	        $orders = $orders->where('item_id','LIKE',"%{$this->item_id}%");
	      }
	    if(($this->start_date != NULL) || ($this->end_date != NULL))
	      {
	        $orders = $orders->whereBetween('date', [$this->start_date, $this->end_date]);
	      }
        return view('manager.excel.item.itemExport', [
    	   'orders' => $orders->with('item','unit')->where('is_confirmed','1')
                    ->select('*', DB::raw('sum(quantity) as sumqty'))
                    ->groupBy('item_id')->get()
        ]);
    }
}
