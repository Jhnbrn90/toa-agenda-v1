@extends ('layouts.master')

@section ('content')
<br>
<div class="container" style="font-family: sans-serif;">
    <center><a href="/" class="text-primary">Terug naar agenda</a></center>
    <br>
    <div class="card">

        <div class="card-header">
            <h4><strong>Aanvraag bewerken</strong></h4>
        </div>

        <div class="card-body">

            @include ('layouts.errors')

             <form method="POST" action="/aanvraag/{{ $task->id }}" autocomplete="off">
               {{ csrf_field() }}
               {{ method_field('PATCH') }}
               <input type="hidden" name="date" id="date" value="{{ $task->date }}">
               <input type="hidden" name="timetable_id" id="timetable_id" value="{{ $task->timetable_id }}">
               <div class="row">
                 <div class="col-md-6">
                   <strong>Datum</strong> <br> {{ $task->date }}
                 </div>
                 <div class="col-md-6">
                   <strong>Lesuur</strong> <br> {{ $task->timetable_id }}e uur ({{ $timetable->find($task->timetable_id)->starttime.' - '.$timetable->find($task->timetable_id)->endtime }})
                 </div>

               </div>
               <div class="form-row">

                 <div class="form-group col-md-5">
                   <label for="title" class="col-form-label"><strong>Titel</strong></label>
                   <input type="text" class="form-control" id="title" name="title" placeholder="Titel" aria-describedby="titleHelpBlock" maxlength="25" autofocus required value="{{ $task->title }}">
                   <small id="titleHelpBlock" class="form-text text-muted">
                     Maximaal 25 tekens (<span class="countdown"></span>/25)
                   </small>
                 </div>
               </div>

               <div class="form-row">
                 <div class="form-group col-md-12">
                   <label for="description" class="col-form-label"><strong>Omschrijving</strong></label>
                   <textarea name="body" id="body" class="form-control" rows="3" placeholder="Beschijving van het practicum: proefopstelling, lesmateriaal, etc.&#10;Bij assistentie: geef ook aan om welk lesdeel het gaat (hele les, eerste deel, tweede deel)" required>{{ $task->body }}</textarea>
                 </div>
               </div>

               <div class="form-row">
                 <div class="form-group col-md-3">
                   <label for="type" class="col-form-label"><strong>Type</strong></label>
                   <select class="form-control custom-select" id="type" name="type" aria-describedby="typeHelpBlock">
                         <option disabled>Kies een type</option>
                         <option value="voorbereiding" @if($task->type == "voorbereiding") selected @endif>Voorbereiding</option>
                         <option value="assistentie" @if($task->type =="assistentie") selected @elseif($notAvailable !== false) disabled @endif>Assistentie</option>
                         <option @if($task->type == "anders") selected @endif value="anders">Anders</option>
                   </select>
                   <small id="typeHelpBlock" class="form-text text-muted">

                   </small>
                 </div>
                 <div class="form-group col-md-2">
                   <label for="class" class="col-form-label"><strong>Klas</strong></label>
                   <input type="text" class="form-control" id="class" name="class" placeholder="3HD" required value="{{ $task->class }}">
                 </div>
                 <div class="form-group col-md-4">
                   <label for="subject" class="col-form-label"><strong>Vak</strong></label>
                   <input type="text" class="form-control" id="subject" name="subject" placeholder="Natuurkunde, Scheikunde, etc." required value="{{ $task->subject }}">
                 </div>
                 <div class="form-group col-md-3">
                   <label for="location" class="col-form-label"><strong>Locatie</strong></label>
                   <input type="text" class="form-control" id="location" name="location" placeholder="B0-1" required value="{{ $task->location }}">
                 </div>
               </div>
               <button type="submit" class="btn btn-success">Opslaan</button>
             </form>

               <div class="pull-right">
                <form action="/aanvraag/{{ $task->id }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btn btn-danger">Verwijderen</button>
              </div>

        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
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
