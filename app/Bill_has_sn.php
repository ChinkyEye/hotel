<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill_has_sn extends Model
{
    public  function createdUser(){
        return $this->belongsTo(User::class,'created_by');
    }
}
