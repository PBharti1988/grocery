<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackApp extends Model
{
    protected $table = 'feedbacks_app';
    use SoftDeletes;
    protected $guarded = [
        'id','created_at','updated_at','deleted_at'
    ];
    
}
