@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar-absence')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
              @include ('layouts.flash')
              <h1>Absenties</h1>
              <div class="container">
                <form action="/admin/absence" method="POST">
                  {{ csrf_field() }}
                  <h3>Nieuwe absentie</h3> <br>
                  <div class="row">
                    <div class="col-md-3">
                      <strong>Datum:</strong>
                      <input type="date" name="date" class="form-control" autofocus required>
                    </div>
                    <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-6">
                      <strong>Lesuren:</strong> <br>
                      @foreach ($timeslots as $timeslot)
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input name="class_hour[]" class="form-check-input class_hour" type="checkbox" value="{{ $timeslot->school_hour }}"> {{ $timeslot->school_hour }}
                          </label>
                        </div>
                      @endforeach
                      <div class="form-check form-check-inline">

                        <a class="btn btn-info btn-sm text-white" id="selectAll" style="cursor:pointer;">Alles selecteren</a>

                      </div>

                    </div>
                  </div>

                  <div class="row" style="padding-top: 20px;">
                    <div class="col-md-10">
                      <strong>Reden:</strong>
                      <textarea name="message" class="form-control" rows="3" placeholder="optioneel"></textarea>
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

@section ('scripts')
<script>

  $("#selectAll").click( function() {
              $(".class_hour").each( function() {
                  $(this).attr('checked', !$(this).attr('checked'));
              });
          });

</script>
@endsection
