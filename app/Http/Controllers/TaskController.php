<?php

namespace App\Http\Controllers;

use App\Task;
use App\Absence;
use App\Timetable;
use Carbon\Carbon;
use App\Mail\EditedTask;
use App\Classes\Weekdays;
use App\Mail\DeletedTask;
use App\Mail\NewTaskRequest;
use Illuminate\Http\Request;
use App\Mail\NewMultiTaskRequest;
use App\Classes\AttachmentHandler;
use App\Classes\EmailDateFormatter;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    private $today;

    public function __construct()
    {
        $this->middleware('auth');
        $this->today = Carbon::parse('now')->toDateString();
    }


    public function index(string $date = 'now')
    {
        // determine which dates to show.
            $today = $this->today;

            $week = new Weekdays($date);
            $weekdays = $week->getDaysofWeek();
            $date_back = $week->getPreviousWeek();
            $date_forward = $week->getNextWeek();

        // Retrieve timeslots.
        $timeslots = Timetable::all();

        // Retrieve asbence
        $absences = Absence::all();

        // Separate tasks into resp. days and timeslots.
        return view('tasks.index', compact('timeslots', 'weekdays', 'date_back', 'date_forward', 'today', 'absences'));
    }

    public function searchDate()
    {
        $date = request('date-DayMonth').'-'.request('date-Year');

        if($date == "") {
            $date = Carbon::now()->format('d-m-Y');
        }

        $this->validate(request(), [
            'date' => 'date'
        ]);

        return redirect('/datum/'.$date);
    }

public function filter(string $date = 'now')
    {
       // today
        $today = Carbon::parse('now')->toDateString();

        // determine which dates to show.
            $week = new Weekdays($date);
            $weekdays = $week->getDaysofWeek();
            $date_back = $week->getPreviousWeek();
            $date_forward = $week->getNextWeek();

        // Retrieve timeslots.
        $timeslots = Timetable::all();
        $tasks = Task::all();

        // Separate tasks into resp. days and timeslots.
        return view('tasks.filter', compact('timeslots', 'weekdays', 'date_back', 'date_forward', 'today', 'tasks'));

    }

    public function create($date, $timeslot)
    {

        $today = $this->today;

        if(Carbon::parse($date) < Carbon::parse($today)) {
            return redirect('/');
        }

        $absenceArray = Absence::getArray($date);

        if(in_array($timeslot, $absenceArray)) {
            return redirect('/');
        }

        $timetable = Timetable::all();
        $notAvailable = Task::where('date', $date)
                        ->where('timetable_id', $timeslot)
                        ->where('accepted', 2)
                        ->pluck('type')
                        ->search('assistentie');

        $formatted_date = Carbon::parse($date)->formatLocalized('%A %d-%m-%Y');

        return view('tasks.create', compact('date', 'formatted_date', 'timeslot', 'timetable', 'notAvailable'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:25',
            'body' => 'required',
            'type' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'location' => 'required'
        ]);

        $user = auth()->user();

        $filepath = (new AttachmentHandler($request))->uploadAttachment();

        $day = EmailDateFormatter::getWeekdayMonth($request->date);
        $time = EmailDateFormatter::getSchoolTime($request->timetable_id);

        if($request->repeat !== null) {
            $setId = str_random();
            $timesToRepeat = $request->repeatby;

            for($i = 0; $i <= $timesToRepeat; $i++) {
                $multiTask = new Task();
                $multiTask->date = Carbon::parse($request->date)->addWeeks($i)->format('d-m-Y');
                $multiTask->timetable_id = $request->timetable_id;
                $multiTask->title = $request->title . ' ('.($i+1).'/'.($timesToRepeat+1).')';
                $multiTask->body = $request->body;
                $multiTask->type = $request->type;
                $multiTask->class = $request->class;
                $multiTask->subject = $request->subject;
                $multiTask->location = $request->location;
                $multiTask->user_id = auth()->id();
                $multiTask->set_id = $setId;
                if($user->is_admin == 1) {
                    $multiTask->accepted = 1;
                }
                $multiTask->save();
            }

            $task = array();
            $task['title'] = $request->title;
            $task['body'] = $request->body;
            $actionURL = env('APP_URL').'/admin/taskset/'.$setId;

            Mail::to(env('APP_ADMIN_EMAIL'))
                ->later(3, new NewMultiTaskRequest($user, $task, $time, $day, $filepath, $actionURL));

            session()->flash('message', 'Aanvraag is succesvol ingediend.');

            return redirect('/');

        } else {

            $task = $user->submit(
                new Task(request(['date', 'timetable_id', 'title', 'body', 'type', 'class', 'subject', 'location']))
            );

            if($user->is_admin == 1) {
                $task->accepted = 1;
                $task->save();
            }

            $actionURL = env('APP_URL').'/admin/task/'.$task->id;

            Mail::to(env('APP_ADMIN_EMAIL'))
                ->later(3, new NewTaskRequest($user, $task, $actionURL, $time, $day, $filepath));

            session()->flash('message', 'Aanvraag succesvol ingediend');

            $redirectURL = EmailDateFormatter::getRedirectURL($request->timetable_id, $request->date);

            return redirect($redirectURL);
        }

    }

    public function edit(Task $task)
    {
        if($task->user_id !== auth()->id()) {
            return redirect('/');
        }

        $today = Carbon::parse('now')->toDateString();

        if(Carbon::parse($task->date) < Carbon::parse($today)) {
            return redirect('/');
        }

        $timetable = Timetable::all();
        $notAvailable = Task::where('date', $task->date)->where('timetable_id', $task->timetable_id)->pluck('type')->search('assistentie');

        return view('tasks.edit', compact('task', 'timetable', 'notAvailable'));
    }

    public function update(Request $request, Task $task)
    {

        if(auth()->id() !== $task->user_id) {
            return redirect('/');
        }

        $user = auth()->user();

        $request->validate([
            'title' => 'required|max:25',
            'body' => 'required',
            'type' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'location' => 'required'
        ]);

        $task->title = request('title');
        $task->body = request('body');
        $task->type = request('type');
        $task->class = request('class');
        $task->subject = request('subject');
        $task->location = request('location');
        $task->accepted = 2;
        $task->save();

        $date = Carbon::parse(request('date'))->startOfWeek()->format('d-m-Y');

        // send an e-mail to the site-admin
        $actionURL = env('APP_URL').'/admin/task/'.$task->id;

        // format the date and time
        $day = EmailDateFormatter::getWeekdayMonth($request->date);
        $time = EmailDateFormatter::getSchoolTime($request->timetable_id);

        // upload files and send email
        $filepath = (new AttachmentHandler($request))->uploadAttachment();
        Mail::to(env('APP_ADMIN_EMAIL'))
            ->later(5, new EditedTask($user, $task, $actionURL, $time, $day, $filepath));

    // redirect user with success flash
        session()->flash('message', 'Wijzigingen zijn opgeslagen.');

        return redirect('/datum/'.$date);

    }


    public function destroy(Task $task)
    {
        if(auth()->id() !== $task->user_id) {
            return redirect('/');
        }

        $user = auth()->user();
        $date = EmailDateFormatter::getWeekdayMonth($task->date);
        $time = EmailDateFormatter::getSchoolTime($task->timetable_id);

        // define all variables here
        $task_vars = array();
        $task_vars['name'] = $task->name;
        $task_vars['title'] = $task->title;
        $task_vars['subject'] = $task->subject;
        $task_vars['type'] = $task->type;
        $task_vars['class'] = $task->class;
        $task_vars['location'] = $task->location;

        $user_vars = array();
        $user_vars['name'] = $user->name;
        $user_vars['email'] = $user->email;

        //let the admin know this task was deleted
        Mail::to(env('APP_ADMIN_EMAIL'))
            ->later(5, new DeletedTask($task_vars, $user_vars, $date, $time));

        $date = Carbon::parse($task->date)->startOfWeek()->format('d-m-Y');

        $task->delete();

        // redirect user with success flash
        session()->flash('message', 'De aanvraag is verwijderd.');

        return redirect('/datum/'.$date);

    }

}
