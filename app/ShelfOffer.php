<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShelfOffer extends Model
{
    //protected $table = 'feedbacks';
    use SoftDeletes;
    protected $guarded = [
        'id','created_at','updated_at','deleted_at'
    ];
    
}
