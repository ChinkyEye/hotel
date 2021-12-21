<?php

namespace App\Exports\Admin;

use App\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class KitchenStockExport implements FromCollection, WithHeadings
{
   private $search = NULL;
   private $category_id = NULL;

   public function __construct($search,$category_id)
   {
       if($search!="") $this->search = $search;
       if($category_id!="") $this->category_id = $category_id;
   }

    public function collection()
   {
       $orders = Stock::orderBy('id','DESC')->where('type',2);
       // dd($orders->get());
       // $orders = Item::orderBy('id','DESC')->where('item_type_id','!=',2);
       if($this->search != NULL)
       {            
           $orders = $orders->where('name', 'LIKE',"%{$this->search}%");
       }
       if($this->category_id != NULL)
       {            
         $orders = $orders->where('category_id', 'LIKE',"%{$this->category_id}%");
        }
       $orders = $orders->get();
       // dd($orders);
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
