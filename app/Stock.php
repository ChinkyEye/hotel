<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Stock extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['name'];
    public function setNameAttribute($value){
   		return $this->attributes['name'] = ucfirst($value);
   	}

   	public function user(){
      	return $this->belongsTo(User::class,'created_by');
  	}

  	public function bought(){
      	return $this->belongsTo(User::class,'bought_user_id');
  	}

  	public function category(){
      	return $this->belongsTo(Category::class,'category_id');
  	}

  	public function unit(){
      	return $this->belongsTo(Unit::class,'unit_id');
  	}
   	
    protected $fillable = [
        'name', 
        'slug', 
        'price',
        'quantity',
        'qty_rem',
        'rate',
        'vat',
        'type',
        'total',
        'unit_id',
        'vendor_id',
        'bought_user_id',
        'category_id',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time',
    ];
}
