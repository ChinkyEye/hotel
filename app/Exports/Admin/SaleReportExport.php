<?php

namespace App\Exports\Admin;

use App\Order_detail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class SaleReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $bill_id = NULL;
    private $user_type = NULL;
    private $table_id = NULL;
    private $bill_type = NULL;
    private $start_date = NULL;
    private $end_date = NULL;

    public function __construct($bill_id, $user_type, $table_id, $bill_type, $start_date, $end_date)
    {
      if($bill_id!="") $this->bill_id = $bill_id;
      if($user_type!="") $this->user_type = $user_type;
      if($table_id!="") $this->table_id = $table_id;
      if($bill_type!="") $this->bill_type = $bill_type;
      if($start_date!="") $this->start_date = $start_date;
      if($end_date!="") $this->end_date = $end_date;
    }

    public function collection()
    {
      $orders = Order_detail::orderBy('id','DESC')->where('bill_type','!=','2')->where('receive_type','0')->where('is_confirmed','1');
      if($this->bill_id != NULL)
        {            
          $orders = $orders->where('bill_id', 'LIKE',"%{$this->bill_id}%");
        }
      if($this->user_type != NULL)
        {
          $orders = $orders->where('usertype_id','LIKE',"%{$this->user_type}%");
        }
      if($this->table_id != NULL)
        {
          $orders = $orders->where('table_id',$this->table_id);
        }
      if($this->bill_type != NULL){
          $orders = $orders->where('bill_type',$this->bill_type);
      }
      if(($this->start_date != NULL) || ($this->end_date != NULL))
        {
          $orders = $orders->whereBetween('date', [$this->start_date, $this->end_date]);
        }
      $total = $orders->sum('total');
      $discount = $orders->sum('discount');
      $received = $orders->sum('received');
      $orders = $orders->with('customer','usertype','table')->get();
        $actualdata = $orders->map(function($order) use(&$total,&$discount,&$received){
          return [$order->id,$order->customer->name,$order->usertype->name,$order->bill_id,$order->table->name, $order->total,$order->discount,$order->received, $order->grand_total - $order->received, $order->created_at];
        });
        $actualdata[] = ["","","","","Final:",$total,$discount,$received,$total-$received+$discount];
        return $actualdata;
    }

    public function headings(): array
    {
        return [
            '#',
            'Customer Info',
            'Type',
            'Bill ID',
            'Table',
            'Total(Rs)',
            'Discount(Rs)',
            'Received(Rs)',
            'Due(Rs)',
            'Issued Date',
        ];
    }



    
}
