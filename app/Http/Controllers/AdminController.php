<?php


namespace App\Http\Controllers;

use JavaScript;
use App\Task;
use App\Timetable;
use Carbon\Carbon;
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

        $formatted_labels = "[".implode(', ', array_keys($taskByHour))."]";
        $unformatted_labels = array_keys($taskByHour);
        $formatted_data = "[".implode(', ', array_values($taskByHour))."]";
        $unformatted_data = array_values($taskByHour);

        JavaScript::put([
            'labels_var'   =>   $unformatted_labels,
            'data_var'     =>   $unformatted_data
        ]);

        return view('admin.index', compact('tasks', 'waitingTasks'));
    }

    public function chart()
    {
        $result = Task::where('accepted', '=', 1)
                            ->where('date', Carbon::parse('now')->format('d-m-Y'))
                            ->orderBy('timetable_id', 'ASC')
                            ->get();

                return response()->json($result);
    }
}
