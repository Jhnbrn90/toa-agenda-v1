<?php


namespace App\Http\Controllers;

use App\Task;
use App\User;
use JavaScript;
use App\Timetable;
use Carbon\Carbon;
use App\Classes\Weekdays;
use App\Classes\TaskSorter;
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

        // fetch info for the bar graphs
        $TasksByHour = (new TaskSorter())->tasksByHour();
        $TasksByDay = (new TaskSorter())->tasksByWeekday();

        // put into variables
        $daytasks = [];
        $daytasks['values'] = "['".implode('\', \'', array_values($TasksByHour))."']";
        $daytasks['labels'] = "['".implode('\', \'', array_keys($TasksByHour))."']";

        $weektasks = [];
        $weektasks['values'] = "['".implode('\', \'', array_values($TasksByDay))."']";
        $weektasks['labels'] = "['".implode('\', \'', array_keys($TasksByDay))."']";

        return view('admin.index', compact('tasks', 'waitingTasks', 'daytasks', 'weektasks'));
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
