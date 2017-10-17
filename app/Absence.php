<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = ['date', 'school_hour', 'message'];
    public $timestamps = false;
}
