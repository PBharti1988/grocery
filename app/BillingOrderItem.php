<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingOrderItem extends Model
{
	public $guarded = ['id','created_at','updated_at'];
}
