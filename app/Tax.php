<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{

    protected $table = 'taxes';
    public $guarded = ['id','created_at','updated_at'];
}
