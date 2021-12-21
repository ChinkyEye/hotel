<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_has_package extends Model
{
    protected $fillable = [
        'canteen_package_id',
        'effective',
        'user_id',
        'created_by',
        'date',
        'date_np',
        'time'
    ];

    public function getPackage()
    {
        return $this->belongsTo('App\Canteen_package');
    }

    public function getUserPackage()
    {
        return $this->belongsTo('App\Canteen_package','canteen_package_id');
    }
}
