<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Item extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['name'];
    
    public function setNameAttribute($value){
   		return $this->attributes['name'] = ucfirst($value);
   	}

   	public  function user(){
      	return $this->belongsTo(User::class,'created_by');
  	}

  	public  function category(){
      	return $this->belongsTo(Category::class,'category_id');
  	}

  	public  function unit(){
      	return $this->belongsTo(Unit::class,'unit_id');
  	}

       public function getunit()
  {
    return $this->belongsTo('App\Unit','unit_id','id');
  }
   	
    protected $fillable = [
        'name', 
        'image_enc', 
        'slug', 
        'price',
        'quantity',
        'unit_id',
        'category_id',
        'item_type_id',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time',
        'qty_rem',
        'stock',
    ];
}
