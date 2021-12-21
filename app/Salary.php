<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'user_id', 
        'month_id',
        'amount',
        'vat',
        'total',
        'type',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time'
    ];

    public  function user(){
      	return $this->belongsTo(User::class,'user_id');
  	}

  	public  function month(){
      	return $this->belongsTo(Month::class,'month_id');
  	}
}
