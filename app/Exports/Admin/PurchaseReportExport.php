<?php

namespace App\Exports\Admin;

use App\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class PurchaseReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $buyer_id = NULL;
    private $search = NULL;
    private $category_id = NULL;
    private $start_date = NULL;
    private $end_date = NULL;

    public function __construct($buyer_id,$search,$category_id ,$start_date,$end_date)
    {
        if($buyer_id!="") $this->buyer_id = $buyer_id;
        if($search!="") $this->search = $search;
        if($category_id!="") $this->category_id = $category_id;
        if($start_date!="") $this->start_date = $start_date;
        if($end_date!="") $this->end_date = $end_date;
    }

     public function collection()
    {
        $orders = Stock::orderBy('id','DESC');
        if($this->buyer_id != NULL)
          {            
            $orders = $orders->where('buyer_id', 'LIKE',"%{$this->buyer_id}%");
          }
          
        if(($this->start_date != NULL) || ($this->end_date != NULL))
          {
            $orders = $orders->whereBetween('date', [$this->start_date, $this->end_date]);
          }
        $orders = $orders->get();
        return $orders;
    }

    public function headings(): array
    {
        return [
            '#',
            'Category',
            'Name',
            'Price',
            'Quantity',
            'VAT',
            'Rate',
            'Total',
            'Unit',
        ];
    }

   
}
