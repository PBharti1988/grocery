<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qrcode extends Model
{
	use SoftDeletes;
    public $guarded = ['id','created_at','updated_at'];
    //
}
