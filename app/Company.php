<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
	  /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
