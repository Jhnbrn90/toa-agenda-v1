@extends ('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/simplemde.css') }}">
@endsection

@section ('content')
<br>

<div class="container" style="font-family: sans-serif;">
  <center><a href="/" class="text-primary">Terug naar agenda</a></center>
  <br>
  <center>
  <div class="card" style="width: 80%; text-align:left;">
    <div class="card-header">
      <strong>Nieuwe Aanvraag</strong>
    </div>
    <div class="card-body">

     @include ('layouts.errors')

      <form method="POST" action="/aanvraag/nieuw" autocomplete="off" enctype="multipart/form-data">
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

          <div class="form-group col-md-5">
            <label for="title" class="col-form-label"><strong>Titel</strong></label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Titel" aria-describedby="titleHelpBlock" maxlength="25" value="{{ old('title') }}" autofocus required>
            <small id="titleHelpBlock" class="form-text text-muted">
              Maximaal 25 tekens (<span class="countdown"></span>/25)
            </small>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="body" class="col-form-label"><strong>Omschrijving</strong></label>
            <textarea name="body" id="body" class="form-control" placeholder="Beschijving van het practicum: proefopstelling, lesmateriaal, etc.&#10;Bij assistentie: geef ook aan om welk lesdeel het gaat (hele les, eerste deel, tweede deel)">{{ old('body') }}</textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="upload" class="col-form-label"><strong>Bestand bijvoegen</strong> (optioneel)</label><br>
            <input type="file" name="file[]" class="form-control-file" multiple>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="type" class="col-form-label"><strong>Type</strong></label>
            <select class="form-control custom-select" id="type" name="type" aria-describedby="typeHelpBlock">
                  <option disabled selected>Kies een type</option>
                  <option value="voorbereiding">Voorbereiding</option>
                  <option value="assistentie" @if($notAvailable !== false) disabled @endif>Assistentie</option>
                  <option value="anders">Anders</option>
            </select>
            <small id="typeHelpBlock" class="form-text text-muted">

            </small>
          </div>
          <div class="form-group col-md-2">
            <label for="class" class="col-form-label"><strong>Klas</strong></label>
            <input type="text" class="form-control" id="class" name="class" placeholder="3HD" value="{{ old('class') }}" required>
          </div>
          <div class="form-group col-md-4">
            <label for="subject" class="col-form-label"><strong>Vak</strong></label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Natuurkunde, Scheikunde, etc." value="{{ old('subject') }}" required>
          </div>
          <div class="form-group col-md-3">
            <label for="location" class="col-form-label"><strong>Locatie</strong></label>
            <input type="text" class="form-control" id="location" name="location" placeholder="B0-1" value="{{ old('location') }}" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Verzenden</button>
      </form>
    </div>
  </div>
</div>
</center>
@endsection

@section('scripts')
<script>
  var simplemde = new SimpleMDE({
    spellChecker: false,
    hideIcons: ["image", "heading", "link"],
  });

  jQuery(document).ready(function($) {
      updateCountdown();
      $('#title').change(updateCountdown);
      $('#title').keyup(updateCountdown);
  });

  function updateCountdown() {
      var remaining = 25 - jQuery('#title').val().length;
      jQuery('.countdown').text(remaining + '');
  }
</script>
@endsection
