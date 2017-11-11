<?php
namespace App\Classes;

use App\Timetable;
use Carbon\Carbon;

class EmailDateFormatter {

    public static function getWeekdayMonth($date)
    {
        return ucfirst(Carbon::parse($date)->formatLocalized("%A %e %B"));
    }

    public static function getSchoolTime($timetable_id)
    {
        $timetable = Timetable::where('id', $timetable_id)->first();
        return $timetable->school_hour."e uur";
    }

    public static function getRedirectURL($timetable_id, $date)
    {
        $rawDate = Carbon::parse($date);
        $date = $rawDate->format('d-m-Y');

        switch($timetable_id) {
            case 1:
                $time = 1;
                break;
            default:
                $time = $timetable_id - 1;
                break;
        }

        $root_date = $rawDate->startOfWeek()->format('d-m-Y');

        return '/datum/'.$root_date.'#'.$date.'H'.$time;

    }
}
