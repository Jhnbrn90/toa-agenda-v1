<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{

    public function __construct() {
        $this->middleware('auth');

    }

    public function create($date, $timeslot)
    {
        $carbonDate = Carbon::parse($date);
        $timetable = Timetable::where('school_hour', $timeslot)->first();
        return view('absence.create', compact('date', 'carbonDate', 'timetable', 'timeslot'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => '',
            'date' => 'required',
            'school_hour' => 'required'
        ]);

        $date = Carbon::parse(request('date'))->format('d-m-Y');

        // check if there is already absence on this day
        $absence = Absence::where('date', $date)->first();

        if($absence !== null && $absence->count() > 0) {
            $absence->school_hour = $absence->school_hour.", ".$request->school_hour;
            $absence->save();
        } else {
            Absence::create($validated);
        }


        if(request('school_hour') == 1) {
            $time = 1;
        } else {
            $time = request('school_hour')-1;
        }

        $startdate = Carbon::parse(request('date'))->startOfWeek()->format('d-m-Y');

        session()->flash('message', 'Absentie verwerkt.');

        return redirect('/datum/'.$startdate.'#'.$date.'H'.$time);

    }

    public function index()
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $absence_table = Absence::orderBy('id', 'DESC')->get();

        return view('absence.index', compact('absence_table'));

    }

    public function create_admin()
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        // pass through the timetable
        $timeslots = Timetable::all();

        return view('absence.create_admin', compact('timeslots'));

    }

    public function store_admin(Request $request)
    {
        $request->validate([
            'date' => 'required'
        ]);

        // transform date to Carbon instance
        $date = Carbon::parse($request->date)->format('d-m-Y');

        $school_hours = implode(', ', $request->school_hour);

        Absence::create([
            'date'          => $date,
            'message'       => $request->message,
            'school_hour'   => $school_hours
        ]);

        session()->flash('message', 'Absentie verwerkt.');

        return redirect('/admin/absence');

    }

    public function edit(Absence $absence)
    {
        $date = Carbon::parse($absence->date)->format('Y-m-d');
        return view('absence.edit', compact('absence', 'date'));
    }

    public function update(Request $request, Absence $absence)
    {
        $request->validate([
            'date'          => 'required',
            'school_hour'   => 'required'
        ]);

        $absence->date = request('date');
        $absence->school_hour = request('school_hour');
        $absence->message = request('message');
        $absence->save();

        session()->flash('message', 'Absentie aangepast.');

        return redirect('/admin/absence');

    }

    public function destroy(Absence $absence)
    {
        $absence->delete();

        session()->flash('message', 'Absentie verwijderd.');

        return redirect('/admin/absence');
    }
}
