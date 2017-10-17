<?php

namespace App\Http\Controllers;

use App\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
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

        \App\Absence::create($validated);


        if(request('school_hour') == 1) {
            $time = 1;
        } else {
            $time = request('school_hour')-1;
        }

        $date = Carbon::parse(request('date'))->format('d-m-Y');
        $startdate = Carbon::parse(request('date'))->startOfWeek()->format('d-m-Y');

        session()->flash('message', 'Absentie verwerkt.');

        return redirect('/datum/'.$startdate.'#'.$date.'H'.$time);

    }
}
