<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminModule extends Model
{
    protected $table = 'admin_modules';
    public $guarded = ['id','created_at','updated_at'];
}
