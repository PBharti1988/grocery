<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminModulePrivilege extends Model
{
    protected $table = 'admin_module_privileges';
    public $guarded = ['id','created_at','updated_at'];
}
