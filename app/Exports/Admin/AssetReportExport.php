<?php

namespace App\Exports\Admin;

use App\Stock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth;
use DB;

class AssetReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $buyer_id = NULL;
    private $search = NULL;
    private $category_id = NULL;
    public function __construct($buyer_id,$search,$category_id)
	{
		if($buyer_id!="") $this->buyer_id = $buyer_id;
		if($search!="") $this->search = $search;
		if($category_id!="") $this->category_id = $category_id;
	}
    public function view(): View
    {
	    $assets = Stock::orderBy('id','DESC')->where('type','4');
	    if($this->buyer_id != NULL)
	      {
	        $assets = $assets->where('bought_user_id','LIKE',"%{$this->buyer_id}%");
	      }
	    if($this->search != NULL)
	      {
	        $assets = $assets->where('name','LIKE',"%{$this->search}%");
	      }
	    if($this->category_id != 0)
	      {            
	        $assets = $assets->where('category_id', $this->category_id);
	      }
        return view('admin.excel.asset.assetExport', [
    	   'assets' => $assets->with('category','unit','bought')->where('is_active','1')->get()
        ]);
    }
}