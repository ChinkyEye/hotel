<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeExpenseTopic extends Model
{
    public function setNameAttribute($value){
   		return $this->attributes['name'] = ucfirst($value);
   	}
   	
    protected $fillable = [
        'name', 
        'slug',
        'type',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time'
    ];
}
