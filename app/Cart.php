<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
      protected $fillable = [
        'quantity', 'item_id','time','date_en','created_by','updated_by'
    ];
    //
      public function getItems()
	{
		return $this->belongsTo('App\Item','item_id','id');
	}

}