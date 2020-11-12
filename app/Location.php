<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    protected $table = 'store_locations';
    use SoftDeletes;
    protected $guarded = [
        'id','created_at','updated_at','deleted_at'
    ];
    
}
