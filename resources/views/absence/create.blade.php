@extends ('layouts.master')

@include('layouts.navbar')

@section ('content')

    <div class="container" style="padding-top: 50px;">
        <div class="card">
            <div class="card-header"><h4>Nieuwe afwezigheidsmelding</h4></div>
            <div class="card-body">
                <form action="/afwezig" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="date" id="date" value="{{ $date }}">
                    <input type="hidden" name="school_hour" id="school_hour" value="{{ $timeslot }}">
                    Datum: {{ $carbonDate->formatLocalized('%A %e %B') }} <br>
                    Lesuur: {{ $timetable->school_hour }}e uur ({{ $timetable->starttime }} - {{ $timetable->endtime }})
                    <br><br>
                    Reden:
                    <textarea name="message" class="form-control" rows="3" autofocus></textarea>
                    <br><br>
                    <button class="btn btn-primary">Verzenden</button>
                </form>
            </div>
        </div>
    </div>

@endsection
