<?php

namespace App\Http\Controllers;

use App\Task;
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
