<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleModule extends Model
{
    protected $table = 'role_modules';
    public $guarded = ['id'];
}
