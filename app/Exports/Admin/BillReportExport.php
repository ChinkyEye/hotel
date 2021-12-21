<?php

namespace App\Exports\Admin;

use App\Bill_has_sn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class BillReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $bill_id = NULL;
    private $start_date = NULL;
    private $end_date = NULL;

    public function __construct($bill_id, $start_date, $end_date)
	{
		if($bill_id!="") $this->bill_id = $bill_id;
		if($start_date!="") $this->start_date = $start_date;
		if($end_date!="") $this->end_date = $end_date;
	}

    public function collection()
    {
	    $orders = Bill_has_sn::orderBy('id','DESC');
	    if($this->bill_id != NULL)
	      {            
	        $orders = $orders->where('bill_id', 'LIKE',"%{$this->bill_id}%");
	      }
	    if(($this->start_date != NULL) || ($this->end_date != NULL))
	      {
	        $orders = $orders->whereBetween('date', [$this->start_date, $this->end_date]);
	      }
	    $orders = $orders->with('createdUser')->get();
        return $orders;
    }

    public function headings(): array
    {
        return [
            '#',
            'Bill ID',
            'SN',
            'Print',
            'Print Times',
            'Created By',
            'Created At',
        ];
    }
}
