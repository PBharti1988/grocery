<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    public $timestamps = false;
    public $guarded = ['id'];
}
