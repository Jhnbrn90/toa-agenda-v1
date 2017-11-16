<?php
namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Timetable;
use Carbon\Carbon;
use App\Mail\DeniedTask;
use App\Classes\Weekdays;
use App\Mail\AcceptedTask;
use App\Classes\TaskSorter;
use Illuminate\Http\Request;
use App\Mail\AcceptedMultiTask;
use App\Mail\RejectedMultiTask;
use App\Classes\EmailDateFormatter;
use Illuminate\Support\Facades\Mail;

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
        $waitingTasks = Task::whereNull('set_id')->where('accepted', '=', 2)->orderBy('id', 'desc')->get();

        $waitingSetIds = Task::where('accepted', '=', 2)
                        ->whereNotNull('set_id')
                        ->groupBy('set_id')
                        ->select('set_id')
                        ->pluck('set_id');

        $waitingSets = array();

        foreach($waitingSetIds as $setId) {
            $waitingSets[] = Task::where('set_id', $setId)->first();
        }


        // fetch info for the bar graphs
        $TasksByHour = (new TaskSorter())->tasksByHour();
        $TasksByDay = (new TaskSorter())->tasksByWeekday();

        // put into variables
        $daytasks['values'] = "['".implode('\', \'', array_values($TasksByHour))."']";
        $daytasks['labels'] = "['".implode('\', \'', array_keys($TasksByHour))."']";

        $weektasks['values'] = "['".implode('\', \'', array_values($TasksByDay))."']";
        $weektasks['labels'] = "['".implode('\', \'', array_keys($TasksByDay))."']";

        $isWeekend = Carbon::parse('now')->isWeekend();

        return view('admin.index', compact('tasks', 'waitingTasks', 'waitingSets', 'daytasks', 'weektasks', 'isWeekend'));
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
                $actionURL = env('APP_URL').'/aanvraag/' . $task->id . '/bewerken';
                $time = EmailDateFormatter::getSchoolTime($task->timetable_id);
                $day = EmailDateFormatter::getWeekdayMonth($task->date);

                Mail::to($task->user->email)
                        ->later(3, new AcceptedTask($task, $actionURL, $time, $day));
            break;

            case 'deny':
                // request denied rules
                $task->accepted = 0;
                $task->message = request('message');
                $task->save();

                session()->flash('message', 'Aanvraag geweigerd.');

                // generate and send email to user
                $time = EmailDateFormatter::getSchoolTime($task->timetable_id);
                $day = EmailDateFormatter::getWeekdayMonth($task->date);

                Mail::to($task->user->email)
                        ->later(3, new DeniedTask($task, $time, $day));

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
        $tasks = Task::orderBy('created_at', 'DESC')->get();

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

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email',
            'shortname'     => 'required',
            'userrole'      => 'required'
        ]);

        $user = User::find($request->userId);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->shortname = $request->shortname;
        $user->is_admin = $request->userrole;
        $user->save();

        session()->flash('message', 'Gebruiker bijgewerkt');

        return redirect('/admin/users/manage');

    }

    public function destroyUser(User $user)
    {
        $user->delete();

        session()->flash('message', 'Gebruiker verwijderd');

        return redirect('/admin/users/manage');
    }

    public function showTaskset($taskset)
    {
        $taskSet = Task::where('set_id', $taskset)->where('accepted', '=', 2);
        if($taskSet->count() == 0) {
            return back();
        }
        $taskSet_title = substr($taskSet->pluck('title')->first(), 0, -6);
        $taskSet_day = Carbon::parse($taskSet->first()->date)->formatLocalized('%A');
        $taskSet_time = $taskSet->first()->timetable->school_hour;

        $taskSet_email = $taskSet->first()->user->email;

        $taskSet = Task::where('set_id', $taskset)->orderBy('id', 'ASC')->get();
        $taskSet_id = $taskset;

        return view('admin.showtaskset', compact('taskSet', 'taskSet_id', 'taskSet_title', 'taskSet_email', 'taskSet_day', 'taskSet_time'));
    }

    public function storeTaskset(Request $request)
    {

        if($request->tasks == null) {
            return back();
        }

        // get the set_id token
        $taskSet_id = $request->taskset_id;

        $acceptedTasks = array();
        $deniedTasks = array();

        foreach($request->tasks as $task_id) {
            $task = Task::where('id', $task_id)->first();
            $task->accepted = 1;
            $task->message = $request->message;
            $task->save();
            $acceptedTasks[] = $task;
        }

        $deniedTasks = Task::where('set_id', $taskSet_id)->where('accepted', '=', 2)->get();

        foreach($deniedTasks as $task) {
            $task->accepted = 0;
            $task->message = $request->message;
            $task->save();
            $deniedTasks[] = $task;
        }


        // generate and send email to user
        $taskHour = $request->taskset_time;
        $taskTitle = $request->taskset_title;
        $acceptedDates = array();
        $deniedDates = array();

        foreach($acceptedTasks as $acceptedTask) {
            $acceptedDates[] = EmailDateFormatter::getWeekdayMonth($acceptedTask->date);
        }
        foreach($deniedTasks as $deniedTask) {
            $deniedDates[] = EmailDateFormatter::getWeekdayMonth($deniedTask->date);
        }

        $acceptedDates = implode(", ", $acceptedDates);
        $deniedDates = implode(", ", $deniedDates);

        Mail::to($request->taskset_email)
            ->later(3, new AcceptedMultiTask($taskTitle, $taskHour, $acceptedDates, $deniedDates, $request->message));

        session()->flash('message', 'Geselecteerde taken geaccepteerd.');

        return redirect('/admin');

    }

    public function deleteTaskset(Request $request)
    {
        $tasks = Task::where('set_id', $request->taskset_id)->get();
        $taskTitle = substr($tasks->first()->title, 0, -6);
        $taskHour = $tasks->first()->timetable->school_hour;

        $dates = array();

        foreach($tasks as $task) {
            $task->accepted = 0;
            $task->message = $request->message;
            $task->save();
            $dates[] = EmailDateFormatter::getWeekdayMonth($task->date);
        }

        $dates = implode(", ", $dates);

        Mail::to($request->taskset_email)
            ->later(3, new RejectedMultiTask($taskTitle, $taskHour, $dates, $request->message));

        session()->flash('message', 'Alle verzoeken geweigerd.');

        return redirect('/admin');

    }

}
