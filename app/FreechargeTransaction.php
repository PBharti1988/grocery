<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreechargeTransaction extends Model
{
    protected $table = 'fc_transactions';
    public $guarded = ['id','created_at','updated_at'];
}
