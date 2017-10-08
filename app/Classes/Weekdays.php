<?php
namespace App\Classes;
use Carbon\Carbon;

class Weekdays {

    public $startDate;
    public $previous;
    public $next;
    public $weekend = false;
    public $weekdays_array = [];
    public $parseDate = '10-10-2017';

    public function __construct(string $startDate)
    {
        $this->startDate = Carbon::parse($startDate);

        if($this->startDate->isWeekend()) {
            $this->weekend = true;
        }
    }

    public function getDaysofWeek()
    {
        if($this->weekend === true) {
            $start = (clone $this->startDate)->startofWeek()->addWeek(1);
        } else {
            $start = clone $this->startDate;
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
        $previous = (clone $this->startDate)->subWeek()->startOfWeek()->format('d-m-Y');

        // if the requested date is a weekend day, return the starting monday
        if($this->weekend === true) {
            $previous = (clone $this->startDate)->startOfWeek()->format('d-m-Y');
        } else {
            // if the previous week is our current week, begin with the current day
            if($previous == Carbon::parse($this->parseDate)->startOfWeek()->format('d-m-Y')) {
                $previous = Carbon::parse($this->parseDate)->format('d-m-Y');
            }
            if($previous == Carbon::parse($this->parseDate)->format('d-m-Y')) {
                $previous = (clone $this->startDate)->subWeek(1)->format('d-m-Y');
            }
        }

        return $previous;
    }

    public function getNextWeek()
    {
        $next = (clone $this->startDate)->addWeek()->startOfWeek()->format('d-m-Y');
        // 02-10-2017

        if($this->weekend == true) {
           $next = (clone $this->startDate)->addWeek(2)->startOfWeek()->format('d-m-Y');
        } else {
            if($next == (Carbon::parse($this->parseDate))->startOfWeek()->format('d-m-Y')) {
                $next = Carbon::parse($this->parseDate)->format('d-m-Y');
            }
            if($next == Carbon::parse($this->parseDate)->format('d-m-Y')) {
                $next = (clone $this->startDate)->addWeek()->format('d-m-Y');
            }

        }

        return $next;
    }
}
