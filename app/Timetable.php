<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $table = 'timetable';

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
