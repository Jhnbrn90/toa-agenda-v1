<?php
namespace App\Classes;

use App\Task;
use App\Timetable;
use App\Classes\Weekdays;
use Carbon\Carbon;

class TaskSorter {

    protected $today;
    protected $tasksByHour;
    protected $timeslots;

    public function __construct() {
        $this->today = Carbon::parse('now')->format('d-m-Y');
        $this->timeslots = Timetable::pluck('school_hour');
        $this->tasksByHour = [];
    }

    public function tasksByHour()
    {
        for($i = 0; $i < count($this->timeslots); $i++) {
           $this->tasksByHour[$this->timeslots[$i]] = Task::where('date', $this->today)->where('timetable_id', $this->timeslots[$i])->count();
        }

        return $this->tasksByHour;

    }

    public function tasksByWeekday()
    {
        $TasksByDay = [];

        $weekdays = (new Weekdays($this->today))->getDaysofWeek();

        foreach($weekdays as $weekday) {
            // calculate the tasks for this day
            $numberOfTasks = Task::where('date', $weekday->format('d-m-Y'))->count();

            // save values to array
            $TasksByDay[$weekday->formatLocalized('%a')] = $numberOfTasks;
        }

        return $TasksByDay;

    }

}

