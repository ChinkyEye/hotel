<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckInHasRoom extends Model
{
    protected $fillable = [
        'checkin_id', 
        'room_id', 
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time'
    ];

    public  function getRoom(){
        return $this->belongsTo(Room::class,'room_id');
    }

}
