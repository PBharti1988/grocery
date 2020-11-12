<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsConfig extends Model
{
    protected $table = 'sms_config';
    public $guarded = ['id'];
}
