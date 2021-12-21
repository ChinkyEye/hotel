<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configure extends Model
{
     protected $fillable = [
        'income_bill', 'income_receiveamount','expense_asset','expense_ispaid','date','time','date_np','time_np','is_active','created_by','updated_by',
    ];
}
