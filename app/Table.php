<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public $guarded = ['id','created_at','updated_at'];
}
