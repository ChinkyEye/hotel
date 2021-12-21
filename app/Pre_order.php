<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pre_order extends Model
{
    //
     protected $fillable = [
        'quantity', 'item_id','table_id','user_id','created_by','updated_by'
    ];
    //
      public function getItems()
	{
		return $this->belongsTo('App\Item','item_id','id');
	}


	  public function getUser()
	{
		return $this->belongsTo('App\User','user_id','id');
	}
}


