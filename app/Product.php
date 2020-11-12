<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "items";
    protected $guarded = [
        'id','created_at','updated_at','deleted_at'
    ];
    
}
