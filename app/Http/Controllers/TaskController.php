<?php

namespace App\Http\Controllers;

use App\Task;
use App\Timetable;
use Carbon\Carbon;
use App\Classes\Weekdays;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(string $date = 'now')
    {
        // determine which dates to show.
            $week = new Weekdays($date);

            $weekdays = $week->getDaysofWeek();
            $date_back = $week->getPreviousWeek();
            $date_forward = $week->getNextWeek();

        // Retrieve timeslots.
        $timeslots = Timetable::all();

        // Separate tasks into resp. days and timeslots.
        return view('tasks.index', compact('timeslots', 'weekdays', 'date_back', 'date_forward'));
    }

    public function create($date, $timeslot)
    {
        $timetable = Timetable::all();
        $notAvailable = Task::where('date', $date)->where('timetable_id', $timeslot)->pluck('type')->search('assistentie');
        return view('tasks.create', compact('date', 'timeslot', 'timetable', 'notAvailable'));
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'title' => 'required|max:20',
            'body' => 'required',
            'type' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'location' => 'required'
        ]);

        auth()->user()->create(
            new Task(request(['date', 'timetable_id', 'title', 'body', 'type', 'class', 'subject', 'location']))
        );

        // redirect user with success flash
        // session()->flash('message', 'Aanvraag succesvol ingediend');

        return redirect('/');
    }

}
