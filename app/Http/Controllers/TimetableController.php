<?php

namespace App\Http\Controllers;

use App\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function show()
    {

        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $timeslots = Timetable::all();
        return view('admin.settings', compact('timeslots'));

    }

    public function update(Request $request, Timetable $timeslot)
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $validated = $request->validate([
            'starttime' => 'required',
            'endtime' => 'required'
            ]);

        Timetable::find($timeslot->id)->update($validated);

        session()->flash('message', 'Lesuur aangepast.');

        return redirect('/admin/settings');
    }

    public function store(Request $request)
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $validated = $request->validate([
            'school_hour'   => 'required',
            'starttime'     => 'required',
            'endtime'       => 'required'
        ]);

        $timeslot = new Timetable($validated);
        $timeslot->id = $validated['school_hour'];
        $timeslot->save();

        session()->flash('message', 'Lesuur toegevoegd.');

        return redirect('/admin/settings');
    }

    public function destroy(Timetable $timeslot)
    {
        if( ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $timeslot->delete();
        session()->flash('message', 'Lesuur verwijderd.');

        return redirect('/admin/settings');
    }
}
