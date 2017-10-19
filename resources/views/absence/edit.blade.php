@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar-absence')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
              @include ('layouts.flash')
              <h1>Absentie bewerken</h1>
              <div class="container">
                <form action="/admin/absence/{{ $absence->id }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('PATCH') }}
                  <div class="row">
                    <div class="col-md-3">
                      <strong>Datum:</strong>
                      <input type="date" name="date" class="form-control" value="{{ $date }}" autofocus required>
                    </div>
                    <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-6">
                      <strong>Lesuren:</strong> <br>
                      @foreach ($timeslots as $timeslot)
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input name="school_hour[]" class="form-check-input class_hour" type="checkbox" value="{{ $timeslot->school_hour }}"
                            @if (in_array($timeslot->school_hour, $absenceArray))
                              checked
                            @endif
                            > {{ $timeslot->school_hour }}
                          </label>
                        </div>
                      @endforeach
                      <!-- <input type="text" class="form-control" name="school_hour" value="{{ $absence->school_hour }}" required> -->
                    </div>
                  </div>

                  <div class="row" style="padding-top: 20px;">
                    <div class="col-md-10">
                      <strong>Reden:</strong>
                      <textarea name="message" class="form-control" rows="3" placeholder="optioneel">{{ $absence->message }}</textarea>
                      </center>
                    </div>
                    <div class="col-md-1">&nbsp;</div>
                  </div>

                  <div class="row" style="padding-top: 20px;">
                    <div class="col-md-12">
                      <button class="btn btn-primary">Opslaan</button>
                    </div>
                  </div>
                </form>
              </div>

            </main>
          </div>
        </div>
@endsection
