@extends ('layouts.master')

@section ('content')
<br>

<div class="container" style="font-family: sans-serif;">
  <center><a href="/" class="text-primary">Terug naar agenda</a></center>
  <br>
  <!-- <div class="row">
    <div class="col-md-1">
      &nbsp;
    </div>
    <div class="col-md-10">

    </div>
  </div> -->
  <center>
  <div class="card" style="width: 80%">
    <div class="card-header">
      <strong>Nieuwe Aanvraag</strong>
    </div>
    <div class="card-body">
      <form method="POST" action="/aanvraag/nieuw">
        {{ csrf_field() }}
        <input type="hidden" name="date" id="date" value="{{ $date }}">
        <input type="hidden" name="timetable_id" id="timetable_id" value="{{ $timeslot }}">
        <div class="row">
          <div class="col-md-6">
            <strong>Datum</strong> <br> {{ $date }}
          </div>
          <div class="col-md-6">
            <strong>Lesuur</strong> <br> {{ $timeslot }}e uur ({{ $timetable->find($timeslot)->starttime.' - '.$timetable->find($timeslot)->endtime }})
          </div>

        </div>
        <div class="form-row">
          <div class="form-group col-md-1">&nbsp;</div>
          <div class="form-group col-md-10">
            <label for="title" class="col-form-label"><strong>Titel</strong></label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Titel" aria-describedby="titleHelpBlock" autofocus>
            <small id="titleHelpBlock" class="form-text text-muted">
              Maximaal 20 tekens
            </small>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="description" class="col-form-label"><strong>Omschrijving</strong></label>
            <textarea name="body" id="body" class="form-control" rows="3" placeholder="Beschijving van practicum: proefopstelling, lesmateriaal, etc."></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="type" class="col-form-label"><strong>Type</strong></label>
            <select class="form-control" id="type" name="type" aria-describedby="typeHelpBlock">
                  <option >Voorbereiding</option>
                  <option @if($notAvailable !== false) disabled @endif>Assistentie</option>
                  <option>Anders</option>
            </select>
            <small id="typeHelpBlock" class="form-text text-muted">
              Kies voorbereiding / assistentie / etc / ..
            </small>
          </div>
          <div class="form-group col-md-2">
            <label for="class" class="col-form-label"><strong>Klas</strong></label>
            <input type="text" class="form-control" id="class" name="class" placeholder="3HD">
          </div>
          <div class="form-group col-md-2">
            <label for="subject" class="col-form-label"><strong>Vak</strong></label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Nask">
          </div>
          <div class="form-group col-md-4">
            <label for="location" class="col-form-label"><strong>Locatie</strong></label>
            <input type="text" class="form-control" id="location" name="location" placeholder="B0-3">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Verzenden</button>
      </form>
    </div>
  </div>
</div>
</center>
@endsection
