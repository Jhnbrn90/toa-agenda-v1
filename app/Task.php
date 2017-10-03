<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }
}
