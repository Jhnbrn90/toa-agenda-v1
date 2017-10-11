<?php


namespace App\Http\Controllers;

use App\Task;
use App\User;
use JavaScript;
use App\Timetable;
use Carbon\Carbon;
use App\Classes\Weekdays;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        // fetch all tasks.
        $tasks = Task::all();

        // fetch all unapproved tasks.
        $waitingTasks = Task::where('accepted', '=', 2)->orderBy('created_at', 'desc')->get();

        // get all the tasks of today
        $today = Carbon::parse('now')->format('d-m-Y');
        $timeslots = Timetable::pluck('school_hour');
        $taskByHour = [];
            for($i = 0; $i < count($timeslots); $i++) {
               $taskByHour[$timeslots[$i]] = Task::where('date', $today)->where('timetable_id', $timeslots[$i])->count();
            }

        $unformatted_labels = array_keys($taskByHour);
        $unformatted_data = array_values($taskByHour);

        JavaScript::put([
            'labels_var'   =>   $unformatted_labels,
            'data_var'     =>   $unformatted_data
        ]);

        // get weekoverview of tasks.
        $weekdayArray = [];
        $formattedWeekdays = [];
        $weekdayArrayFormatted = [];

        $week = new Weekdays($today);
        $weekdays = $week->getDaysofWeek();
            foreach($weekdays as $weekday) {
                $weekdayArray[] = $weekday->formatLocalized('%a');
                $formattedWeekdays[] = $weekday->format('d-m-Y');
            }

            foreach($formattedWeekdays as $formattedWeekday) {
               $weekdayArrayFormatted[] = Task::where('date', $formattedWeekday)->count();
            }

        JavaScript::put([
            'week_labels_var'   =>   $weekdayArray,
            'week_data_var'     =>   $weekdayArrayFormatted
        ]);

        return view('admin.index', compact('tasks', 'waitingTasks'));
    }

    public function show(Task $task)
    {
            if( ! auth()->user()->isAdmin()) {
                return redirect('/');
            }
            $today = Carbon::parse('now')->format('d-m-Y');

            $timeslots = Timetable::all();

        return view('admin.showtask', compact('task', 'timeslots', 'today'));

    }

    public function createUser()
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return view('admin.newuser');

    }

    public function showUsers()
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $users = User::all();
        return view('admin.showusers', compact('users'));
    }
}
