<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Manager extends Authenticatable
{
    protected $table = 'restaurant_users';
    public $guarded = ['id','created_at','updated_at'];
}
