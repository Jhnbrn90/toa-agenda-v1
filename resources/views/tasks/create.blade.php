@extends ('layouts.master')

@section ('content')
<br>
    <div class="container" style="font-family: sans-serif;">
        <div class="jumbotron" style="padding-top: 10px;">
            <a href="/" class="text-primary">Terug naar agenda</a>
            <br><br>
            <span style="font-size: 2rem"><u>Nieuwe Aanvraag</u></span>
            <br><br>
            <div class="container">
              <form method="POST" action="/aanvraag/nieuw">
                {{ csrf_field() }}
                <input type="hidden" name="date" id="date" value="{{ $date }}">
                <input type="hidden" name="timetable_id" id="timetable_id" value="{{ $timeslot }}">

                <div class="row">
                  <div class="col-sm-2">Datum</div>
                  <div class="col-sm-10">
                   <strong><h5>
                    {{ $date }} <br> {{ $timeslot }}e uur ({{ $timetable->find($timeslot)->starttime.' - '.$timetable->find($timeslot)->endtime }})
                   </h5></strong>
                  </div>
                </div>
                <br>
                <div class="form-group row">
                  <label for="title" class="col-sm-2 col-form-label">Titel</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titel" autofocus>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="body" class="col-sm-2 col-form-label">Omschrijving</label>
                  <div class="col-sm-10">
                    <textarea name="body" id="body" class="form-control" rows="3" placeholder="Bijv.: Klaarzetten materialen voor demoproef glasvezel: item A, item B, enz."></textarea>
                  </div>
                </div>

                <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="type" id="type-voorbereiding" value="voorbereiding" checked>Voorbereiding</label>
                        </div>
                        <div class="form-check form-check-inline @if($notAvailable !== false) disabled @endif">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="type" id="type-assitentie" value="assistentie" @if($notAvailable !== false) disabled @endif>Assistentie
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="type" id="type-anders" value="anders">Anders
                          </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="class" class="col-sm-2 col-form-label">Klas</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="class" name="class" placeholder="Bijv.: 4VWO">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="subject" class="col-sm-2 col-form-label">Vak</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Bijv.: Nask">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="location" class="col-sm-2 col-form-label">Locatie</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="location" name="location" placeholder="Bijv.: B0-3">
                  </div>
                </div>


                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Verzenden</button>
                  </div>

                </div>
              </form>
            </div>
        </div>
    </div>

@endsection
