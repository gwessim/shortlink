<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkLog extends Model
{
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];
}
