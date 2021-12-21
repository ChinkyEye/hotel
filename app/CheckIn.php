<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    protected $fillable = [
        'user_id', 
        'document_type', 
        'check_in_date',
        'check_out_date',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time',
        'is_check_out',
    ];

    public function getUser()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public  function getCheckInRoom(){
        return $this->hasMany(CheckInHasRoom::class,'checkin_id')->where('is_active','1')->with('getRoom');
    }
}
