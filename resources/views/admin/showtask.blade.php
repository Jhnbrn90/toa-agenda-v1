@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <h1>Aanvraag</h1>
                <div class="row">
                    <div class="col-md-7">

                       <div class="card">
                           <div class="card-header">
                               <strong>{{ $task->timetable->school_hour }}e uur</strong>
                               ({{ $task->timetable->starttime }} - {{ $task->timetable->endtime }})
                               <br>
                               Titel: <strong>{{ $task->title }}</strong>
                           </div>
                           <div class="card-body">

                               {{ $task->body }}
                           </div>
                           <div class="card-footer">
                               <small class="text-muted">
                                   <strong>Datum:</strong> {{ $task->date }} |
                                   <strong>Docent:</strong> {{ $task->user->name }} ({{ $task->user->shortname }}) |
                                   <strong>Klas:</strong> {{ $task->class }}
                               </small>
                           </div>
                       </div>
                       <br>
                       <div class="card">
                           <div class="card-body">
                               <form>
                                   <h3>Bericht: </h3>
                                   <textarea class="form-control" rows="5" autofocus></textarea>
                                   <br>
                                   <button type="submit" class="btn btn-success">Accepteren</button>
                                   <button type="submit" class="btn btn-danger">Weigeren</button>
                               </form>
                           </div>
                       </div>

                    </div>

                    <div class="col-md-5">
                        @foreach($timeslots as $timeslot)
                            @if(
                            ( $results = $timeslot->tasks->where('date', $today)->where('accepted', '>=', 1) )
                            AND
                            $results->count() !== 0
                            )
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-info">
                                       <strong> {{ $timeslot->school_hour }}e uur ({{ $timeslot->starttime }} - {{ $timeslot->endtime }}) </strong>
                                    </li>
                                @foreach($results as $result)
                                    <li class="list-group-item">
                                        <span class="title title-status-{{ $result->accepted }}" t="{{ $result->id }}">
                                            {{ $result->title }}
                                        </span>
                                        ({{ $result->type }})

                                        <div id="desc{{ $result->id }}" class="highlight" style="font-size:0.9rem; display:none;">
                                            {{ $result->body }} <br>
                                            <small>
                                                {{ $result->class }} | {{ $result->location }} | {{ $result->user->name }} | {{ $result->type }}
                                            </small>
                                        </div>

                                    </li>
                                @endforeach
                                </ul>

                            @endif

                        @endforeach
                    </div>

                </div>



            </main>
          </div>
        </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

         $(".title").click(function(){
             $("#desc" + $(this).attr('t')).toggle();
         });

        });
    </script>
@endsection
