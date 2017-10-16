<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $table = 'timetable';
    protected $fillable = ['school_hour', 'starttime', 'endtime'];
    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
