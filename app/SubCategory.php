<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'name','icon','category_id','restaurant_id','enabled'
    ];
}
