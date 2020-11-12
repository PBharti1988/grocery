<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;
    protected $table = "categories";
    protected $guarded = [
        'id','created_at','updated_at','deleted_at'
    ];
    
}
