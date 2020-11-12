<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = [
        'email_address', 'mobile_number','otp','otp_expiry'
    ];
}
