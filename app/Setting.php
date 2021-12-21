<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['name','address','phone','email'];
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'pan',
        'logo',
        'created_by',
        'updated_by',
        'is_active',
        'sort_id',
        'created_at',
        'footer_quote1',
        'footer_quote2',
        'taxamount',
        'date',
        'date_np',
        'time',
        'fiscalyear_id'

    ];
}
