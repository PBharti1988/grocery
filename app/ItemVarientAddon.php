<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemVarientAddon extends Model
{
    protected $table = 'item_varient_addons';
    public $guarded = ['id','created_at','updated_at'];
}
