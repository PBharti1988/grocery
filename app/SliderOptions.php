<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SliderOptions extends Model
{
    //
    protected $table = "slider_options";
	public $guarded = ['id'];

	 public function findCategory(){
        return $this->hasMany('App\Category','category','id');
    }
}
