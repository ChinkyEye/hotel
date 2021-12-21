<?php

namespace App\Exports\Admin;

use App\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class StockReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $search = NULL;
    private $category_id = NULL;
    private $type = NULL;
    private $start_date = NULL;
    private $end_date = NULL;

    public function __construct($search,$category_id,$type ,$start_date,$end_date)
    {
        if($search!="") $this->search = $search;
        if($category_id!="") $this->category_id = $category_id;
        if($type!="") $this->type = $type;
        if($start_date!="") $this->start_date = $start_date;
        if($end_date!="") $this->end_date = $end_date;
    }

   public function collection()
  {
      $orders = Item::orderBy('id','DESC')->where('item_type_id','!=',2);
      if($this->search != NULL)
        {            
          $orders = $orders->where('name', 'LIKE',"%{$this->search}%");
        }
      if($this->type != NULL)
        {            
          $orders = $orders->where('type', 'LIKE',"%{$this->type}%");
        }
        if($this->category_id != NULL)
        {            
            $orders = $orders->where('category_id', 'LIKE',"%{$this->category_id}%");
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
          'Stock',
          'Unit',
          'Type',
          'Unit',
      ];
  }


}
