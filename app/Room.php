<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function setNameAttribute($value){
        return $this->attributes['room_type'] = ucfirst($value);
    }

    protected $fillable = [
        'room_type', 
        'slug',
        'room_no', 
        'no_of_bed', 
        'price', 
        'created_by',
        'is_active',
        'is_available',
        'date',
        'date_np',
        'time'
    ];
}
