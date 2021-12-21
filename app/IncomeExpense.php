<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeExpense extends Model
{
    protected $fillable = [
    	'topic_id',
        'description', 
        'amount', 
        'iedate', 
        'type',
        'created_by',
        'is_active',
        'date',
        'date_np',
        'time'
    ];

    public function getTopic()
    {
        return $this->belongsTo(IncomeExpenseTopic::class,'topic_id','id');
    }
}
