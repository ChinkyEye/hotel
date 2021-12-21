<?php

namespace App\Exports\Manager;

use App\Item;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth;
use DB;

class MenuReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $search = NULL;
    private $category_id = NULL;
    public function __construct($search,$category_id)
	{
		if($search!="") $this->search = $search;
		if($category_id!="") $this->category_id = $category_id;
	}
    public function view(): View
    {
	    $items = Item::orderBy('id','DESC');
	    if($this->search != NULL)
	      {
	        $items = $items->where('name','LIKE',"%{$this->search}%");
	      }
	    if($this->category_id != 0)
	      {            
	        $items = $items->where('category_id', $this->category_id);
	      }
        return view('manager.excel.item.menuExport', [
    	   'items' => $items->with('category','unit')->where('is_active','1')->get()
        ]);
    }
}