<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsType extends Model
{
    protected $table = 'sms_types';
    public $guarded = ['id'];
}
