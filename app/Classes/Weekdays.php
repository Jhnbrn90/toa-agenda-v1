<?php
namespace App\Classes;
use Carbon\Carbon;

class Weekdays {

    public $startDate;
    public $weekdays_array = [];

    public function __construct($startDate = '')
    {
        if(isset($startDate) && $startDate !== "") {
            $this->startDate = Carbon::parse($startDate);
        } else {
            $this->startDate = new Carbon();
        }
    }

    public function getDaysofWeek()
    {
        if($this->startDate->isWeekend()) {
            $start = Carbon::parse('next monday');
        } else {
            $start = $this->startDate;
        }

        $end = new Carbon($start);
        $end->addWeekdays(4);

        while($start <= $end) {
            $weekdays[] = new Carbon($start);
            $start = $start->addWeekdays(1);
        }

        return $weekdays;

    }
}
