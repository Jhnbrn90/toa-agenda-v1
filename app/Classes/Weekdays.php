<?php
namespace App\Classes;
use Carbon\Carbon;

class Weekdays {

    public $startDate;
    public $weekdays_array = [];

    public function __construct(string $startDate)
    {
        $this->startDate = $startDate;
    }


    public function getDaysofWeek()
    {
        if((Carbon::parse($this->startDate))->isWeekend()) {
            $start = Carbon::parse('next monday');
        } else {
            $start = Carbon::parse($this->startDate);
        }

        $end = (new Carbon($start))->addWeekdays(4);

        while($start <= $end) {
            $weekdays[] = new Carbon($start);
            $start = $start->addWeekdays(1);
        }

        return $weekdays;
    }

    public function getPreviousWeek()
    {
        $previous = (Carbon::parse($this->startDate))->startOfWeek()->subWeek()->format('d-m-Y');

        if($previous == (Carbon::parse('now'))->startOfWeek()->format('d-m-Y')) {
            $previous = Carbon::parse('now')->format('d-m-Y');
        }

        return $previous;
    }

    public function getNextWeek()
    {
        $next = (Carbon::parse($this->startDate))->startOfWeek()->addWeek()->format('d-m-Y');

        if($next == (Carbon::parse('now'))->startOfWeek()->format('d-m-Y')) {
            $next = Carbon::parse('now')->format('d-m-Y');
        }

        return $next;
    }
}
