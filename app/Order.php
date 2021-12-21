<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public  function unit(){
        return $this->belongsTo(Unit::class,'unit_id');
    }

    public  function item(){
        return $this->belongsTo(Item::class,'item_id')->with('category');
    }

    public  function createdUser(){
        return $this->belongsTo(User::class,'created_by');
    }

     public  function getUser(){
        return $this->belongsTo('App\User','customer_id','id');
    }
    
}
