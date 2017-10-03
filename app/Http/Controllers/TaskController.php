<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Timetable;
use App\Classes\Weekdays;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // determine which dates to show.
        if($date = request('datum')) {
            $weekdays = (new Weekdays($date))->getDaysofWeek();
            $date_back = Carbon::parse($date)->subWeek()->format('d-m-Y');
            $date_forward = Carbon::parse($date)->addWeek()->format('d-m-Y');
        } else {
            $weekdays = (new Weekdays())->getDaysofWeek();
            $date_back = Carbon::now()->subWeek()->format('d-m-Y');
            $date_forward = Carbon::now()->addWeek()->format('d-m-Y');
        }

        // Retrieve timeslots.
        $timeslots = Timetable::all();

        // Separate tasks into resp. days and timeslots.

        return view('tasks.index', compact('timeslots', 'weekdays', 'date_back', 'date_forward'));
    }

}
