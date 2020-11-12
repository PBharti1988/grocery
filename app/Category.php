<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $guarded = ['id'];
    // protected $guarded = [    	
    //     'category_name','icon','restaurant_id','parent_id','enabled','description'
    // ];


    
}
