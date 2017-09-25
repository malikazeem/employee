<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'time_log';


    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
