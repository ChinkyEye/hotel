<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorDetail extends Model
{
     protected $fillable = [
        'bill_id', 
        'bought_user_id',
        'type_id',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time'
    ];

      public function bought(){
         return $this->belongsTo(User::class,'bought_user_id');
      }
}
