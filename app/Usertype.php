<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Usertype extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['name'];

	public function setNameAttribute($value){
   		return $this->attributes['name'] = ucfirst($value);
   	}
   	
    protected $fillable = [
        'name',
        'discount', 
        'slug', 
        'is_active',
        'type_id',
        'date',
        'date_np',
        'time',
        'created_by',
    ];

    public function getCountUser(){
        return $this->belongsTo(User::class,'id','user_type_id');
    }
}
