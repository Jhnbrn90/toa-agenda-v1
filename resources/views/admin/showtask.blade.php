@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <h1>Aanvraag</h1>
                <div class="row">
                    <div class="col-md-9">

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

                    <div class="col-md-3">
                      <center><h4> {{ ucfirst($task->date->formatLocalized('%A %e %B')) }} </h4></center>
                      <br>
                      @if($acceptedTasks->count() === 0)
                       <center> <strong>Geen andere taken.</strong> </center>
                      @else
                        @foreach($acceptedTasks as $task)
                          <div class="card text-white bg-dark mb-3" style="max-width: 20rem">
                            <h5 class="card-header display-6">
                              {{ $task->timetable->school_hour }}e uur
                            </h5>
                            <div class="card-body">
                              <h6 class="card-subtitle mb-2 text-muted">
                              {{ $task->timetable->starttime }} - {{ $task->timetable->endtime }}
                              </h6>
                              <p class="card-text">
                               <h6> {{ $task->title }} </h6>
                               {{ $task->body }}
                              </p>
                            </div>
                          </div>
                        @endforeach
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
