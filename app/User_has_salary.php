<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_has_salary extends Model
{
    protected $fillable = [
        'salary', 
        'user_id',
        'created_by',
        'date',
        'date_np',
        'time'
    ];
}
