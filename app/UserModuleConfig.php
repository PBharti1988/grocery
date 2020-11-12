<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModuleConfig extends Model
{
    protected $table = 'user_module_config';
    public $guarded = ['id'];
}
