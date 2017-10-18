<?php
namespace App\Http\Controllers;

use App\Task;
use App\User;
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
        $waitingTasks = Task::where('accepted', '=', 2)->orderBy('id', 'desc')->get();

        // fetch info for the bar graphs
        $TasksByHour = (new TaskSorter())->tasksByHour();
        $TasksByDay = (new TaskSorter())->tasksByWeekday();

        // put into variables
        $daytasks['values'] = "['".implode('\', \'', array_values($TasksByHour))."']";
        $daytasks['labels'] = "['".implode('\', \'', array_keys($TasksByHour))."']";

        $weektasks['values'] = "['".implode('\', \'', array_values($TasksByDay))."']";
        $weektasks['labels'] = "['".implode('\', \'', array_keys($TasksByDay))."']";

        $isWeekend = Carbon::parse('now')->isWeekend();

        return view('admin.index', compact('tasks', 'waitingTasks', 'daytasks', 'weektasks', 'isWeekend'));
    }

    public function show(Task $task)
    {
            if( ! auth()->user()->isAdmin()) {
                return redirect('/');
            }

            $acceptedTasks = Task::where('date', $task->date)->where('accepted', 1)->get();

            $today = Carbon::parse('now')->format('d-m-Y');
            $task->date = Carbon::parse($task->date);
            $timeslots = Timetable::all();

        return view('admin.showtask', compact('task', 'acceptedTasks', 'timeslots', 'today'));

    }

    public function updateTask(Request $request, Task $task)
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        switch($request->submit) {
            case 'accept':
                // request accepted rules
                $task->accepted = 1;
                $task->message = request('message');
                $task->save();
                session()->flash('message', 'Aanvraag geaccepteerd.');
                // generate and send email to user

            break;

            case 'deny':
                // request denied rules
                $task->accepted = 0;
                $task->message = request('message');
                $task->save();

                session()->flash('message', 'Aanvraag geweigerd.');
                // generate and send email to user
            break;

            default:
                // something went wrong
                dd('Something went wrong...');
            break;
        }

        return redirect('/admin');
    }

    public function showAllTasks()
    {
        $tasks = Task::orderBy('date', 'DESC')->get();

        return view('admin.showAllTasks', compact('tasks'));
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
