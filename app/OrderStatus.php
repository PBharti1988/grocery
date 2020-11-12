<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
	public $guarded = ['id','created_at','updated_at'];
}
