<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['date', 'timetable_id', 'title', 'body', 'type', 'class', 'subject', 'location'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }

    public function scopeActive($query)
    {
        return $query->where('accepted', '>=', 1);
    }

    public function Carbonize()
    {
        return Carbon::parse($this->date);
    }
}
