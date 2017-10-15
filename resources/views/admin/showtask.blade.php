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
                               <strong>{{ ucfirst($task->date->formatLocalized('%A')) }} {{ $task->timetable->school_hour }}e uur</strong>
                               ({{ $task->timetable->starttime }} - {{ $task->timetable->endtime }})
                               <br>
                               Datum: {{ $task->date->formatLocalized('%e %B %Y') }}
                               <br>
                               Titel: <strong>{{ $task->title }}</strong>
                           </div>
                           <div class="card-body">
                               {{ $task->body }}
                           </div>
                           <div class="card-footer">
                               <small class="text-muted">
                                   <strong>Datum:</strong> {{ $task->date->format('d-m-Y') }} |
                                   <strong>Docent:</strong> {{ $task->user->name }} ({{ $task->user->shortname }}) |
                                   <strong>Klas:</strong> {{ $task->class }}
                               </small>
                           </div>
                       </div>
                       <br>
                       <div class="card">
                           <div class="card-body">
                               <form method="POST" action="/admin/task/{{ $task->id }}">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                   <h3>Bericht: </h3>
                                   <textarea name="message" class="form-control" rows="5" autofocus>{{ $task->message }}</textarea>
                                   <br>
                                   <button name="submit" type="submit" class="btn btn-success" value="accept">Accepteren</button>
                                   <button name="submit" type="submit" class="btn btn-danger" value="deny">Weigeren</button>
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
                                       <strong>{{ $timeslot->school_hour }}e uur ({{ $timeslot->starttime }} - {{ $timeslot->endtime }}) </strong>
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

                        @if($results->count() === 0)
                          <center><strong>Geen andere taken vandaag</strong></center>
                        @endif
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
