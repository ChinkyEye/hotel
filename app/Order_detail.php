<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    public function orderkitchen()
    {
        return $this->hasMany('App\Order','bill_id','bill_id')->where('item_type_id','2')->with(['item','unit']);
    }

    public function orderbar()
    {
        return $this->hasMany('App\Order','bill_id','bill_id')->where('item_type_id','3')->with(['item','unit']);
    }

    public function order()
    {
        return $this->hasMany('App\Order','bill_id','bill_id')->with(['item','unit']);
    }

    public function order_kitchen()
    {
        return $this->hasMany('App\Order','bill_id','bill_id')->where('item_type_id','2')->with(['item','unit']);
    }

    public function order_bar()
    {
        return $this->hasMany('App\Order','bill_id','bill_id')->where('item_type_id','3')->with(['item','unit']);
    }

    public function orderstatus()
    {
        return $this->hasMany('App\Order','bill_id','bill_id')->where('item_type_id','2')->where('status','1')->with(['item','unit']);
    }

    public function orderkitchenprevious()
    {
        return $this->hasMany('App\Order','bill_id','bill_id')->where('item_type_id','2')->where('status','0')->with(['item','unit']);
    }

    public  function customer(){
      	return $this->belongsTo(User::class,'customer_id');
  	}

    public  function table(){
        return $this->belongsTo(Table::class,'table_id');
    }

    public function usertype(){
        return $this->belongsTo(Usertype::class,'usertype_id');
    }

  	public function count()
  	{
  		return $this->hasMany('App\Order','bill_id','bill_id');
  	}

    public  function createdUser(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function allbill()
    {
        return $this->belongsTo('App\Bill_has_sn','bill_id','bill_id');
    }
}
