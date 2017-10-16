@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar-settings')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <h1>Instellingen</h1>
                @include ('layouts.flash')
                <h3>Rooster</h3>
                <br>
                <div class="container">
                    @include ('layouts.errors')

                    <div class="row">
                        <div class="col-md-2"><strong>Lesuur</strong></div>
                        <div class="col-md-2"><strong>Starttijd</strong></div>
                        <div class="col-md-2"><strong>Eindtijd</strong></div>
                    </div>
                   @foreach($timeslots as $timeslot)
                   <form action="/admin/timetable/edit/{{ $timeslot->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field ('PATCH') }}
                      <div class="row">
                          <div class="col-md-2">
                              {{ $timeslot->school_hour }}
                          </div>

                          <div class="col-md-2">
                              <input type="time" name="starttime" placeholder="{{ $timeslot->starttime }}" value="{{ $timeslot->starttime }}" class="form-control">
                          </div>

                          <div class="col-md-2">
                            <input type="time" name="endtime" placeholder="{{ $timeslot->endtime }}" value="{{ $timeslot->endtime }}" class="form-control">
                          </div>

                          <div class="col-md-1">
                              <button type="submit" class="btn btn-success" name="save" value="{{ $timeslot->id }}">Opslaan</button>
                          </form>
                          </div>
                          &nbsp;&nbsp;
                          <div class="col-md-2">
                          <form action="/admin/timetable/edit/{{ $timeslot->id }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-danger" name="delete" value="{{ $timeslot->id }}">Verwijderen</button>
                          </form>
                          </div>
                      </div>
                   @endforeach
                </div>
                <br>
                <h3>Lesuur toevoegen</h3>
                <div class="row">
                    <div class="col-md-2">Lesuur</div>
                    <div class="col-md-2">Starttijd</div>
                    <div class="col-md-2">Eindtijd</div>
                </div>

                <form action="/admin/timetable/new" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" value="" name="school_hour" class="form-control" style="width: 60%">
                    </div>
                    <div class="col-md-2">
                        <input type="time" name="starttime" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input type="time" name="endtime" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">Toevoegen</button>
                    </div>
                </div>
                </form>
                <br><br>
            </main>
          </div>
        </div>
@endsection
