@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar-settings')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <h1>Instellingen</h1>
                <h3>Rooster</h3>
                <br>
                <div class="container">
                    <div class="row">

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="class_hour">Lesuur</label>
                                @foreach($timeslots as $timeslot)
                                    <input type="text" class="form-control" name="class_hour" id="class_hour" value="{{ $timeslot->school_hour }}">
                                    <br>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="start_time">Starttijd</label>
                                @foreach($timeslots as $timeslot)
                                    <input type="text" class="form-control" name="start_time" id="start_time" value="{{ $timeslot->starttime }}">
                                    <br>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="end_time">Eindtijd</label>
                                @foreach($timeslots as $timeslot)
                                    <input type="text" class="form-control" name="end_time" id="end_time" value="{{ $timeslot->endtime }}">
                                    <br>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </main>
          </div>
        </div>
@endsection
