<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Table extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['name'];

	public function setNameAttribute($value){
   		return $this->attributes['name'] = ucfirst($value);
   	}
   	
    protected $fillable = [
        'name', 
        'slug',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time'
    ];
}
