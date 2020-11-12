<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainer extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;
    public $guarded = ['id','created_at','updated_at'];

  
}
