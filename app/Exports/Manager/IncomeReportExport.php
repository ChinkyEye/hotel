<?php

namespace App\Exports\Manager;

use App\IncomeExpense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class IncomeReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $start_date = NULL;
    private $end_date = NULL;

    public function __construct($start_date, $end_date)
    {
        if($start_date!="") $this->start_date = $start_date;
        if($end_date!="") $this->end_date = $end_date;
    }
    

    public function collection()
    {
        $orders = IncomeExpense::where('type',1)->orderBy('id','DESC');
      
        if(($this->start_date != NULL) || ($this->end_date != NULL))
        {
            $orders = $orders->whereBetween('date', [$this->start_date, $this->end_date]);
        }
        $orders = $orders->get();

        $actualdata = $orders->map(function($order){
            return [$order->getTopic->name,$order->description,$order->amount,$order->date];
        });
        return $actualdata;
    }

    public function headings(): array
    {
        return [
            // '#',
            'Topic',
            'Description',
            'Amount',
            'Date',
        ];
    }
}
