<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FiscalYear extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['name'];
    
    protected $fillable = [
        'name', 'start_date','end_date','date_np','time_np','is_active','created_by','updated_by',
    ];
}
