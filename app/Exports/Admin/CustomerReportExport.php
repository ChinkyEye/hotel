<?php

namespace App\Exports\Admin;

use App\Order_detail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class CustomerReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $user_id = NULL;
    private $receive_type = NULL;
    private $bill_type = NULL;
    private $start_date = NULL;
    private $end_date = NULL;
    public function __construct($user_id, $receive_type,$bill_type, $start_date, $end_date)
	{
    // dd($user_id);
		if($user_id!="") $this->user_id = $user_id;
		if($receive_type!="") $this->receive_type = $receive_type;
		if($start_date!="") $this->start_date = $start_date;
		if($end_date!="") $this->end_date = $end_date;
	}
    public function collection()
    {
	     $orders = Order_detail::orderBy('id','DESC')->where('is_confirmed','1')->where('customer_id',$this->user_id);
	    if(($this->start_date != NULL) || ($this->end_date != NULL))
        {
          $orders = $orders->whereBetween('date', [$this->start_date, $this->end_date]);
        }
	    if($this->receive_type != NULL)
        {
          $orders = $orders->where('receive_type',$this->receive_type);
        }
	    if($this->receive_type == 0 && ($this->bill_type != NULL))
        {
          $orders = $orders->where('bill_type',$request->bill_type);
        }
	$total = $orders->sum('total');
    $discount = $orders->sum('discount');
    $grand_total = $orders->sum('grand_total');
    $received = $orders->sum('received');

    $orders = $orders->with('table')->get();

    $actualdata = $orders->map(function($order) use(&$total,&$discount,&$received){
    	return [$order->id,$order->bill_id,$order->table->name, $order->total,$order->discount,$order->received, $order->bill_type != '2'?($order->grand_total - $order->received):'0',$order->bill_type != '2'?($order->bill_type=='1'?'Due':'Paid'):'Receive', $order->created_at];
    });
    $actualdata[] = ["","","Final:",$total,$discount,$received,$total-$received+$discount];
    return $actualdata;
    }

    public function headings(): array
    {
        return [
            '#',
            'Bill ID',
            'Table',
            'Total(Rs)',
            'Discount(Rs)',
            'Received(Rs)',
            'Due(Rs)',
            'Status',
            'Issued Date',
        ];
    }
}
