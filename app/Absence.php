<?php

namespace App;

use App\Absence;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = ['date', 'school_hour', 'message'];
    public $timestamps = false;

    public static function getArray($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        $absence = Absence::where('date', $date)->first();
        if($absence == null) {
            return [];
        }

        return explode(', ', $absence->school_hour);
    }
}
