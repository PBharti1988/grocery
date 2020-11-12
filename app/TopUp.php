<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    protected $table = 'top_ups';
    public $guarded = ['id','created_at','updated_at'];
}
