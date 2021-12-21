<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockHasOut extends Model
{
    protected $fillable = [
        'quantity', 
        'description', 
        'stock_id',
        'unit_id',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time',
    ];
}
