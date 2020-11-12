<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentConfig extends Model
{
    protected $table = 'payment_config';
    public $guarded = ['id'];
}
