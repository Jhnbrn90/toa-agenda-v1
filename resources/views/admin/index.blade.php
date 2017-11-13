@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
              @include ('layouts.flash')
              <h1>Overzicht</h1>

                  <div class="row">
                      <div class="col-md-5">
                        <div class="container">
                          <h4>Openstaande verzoeken</h4>
                          Sets:<br>
                          <ul>
                            @foreach($waitingSets as $taskset)
                              <li>
                                <a href="/admin/taskset/{{ $taskset['set_id'] }}">
                                  {{ substr($taskset['title'], 0, -6) }} ({{ \App\Task::where('set_id', $taskset['set_id'])->count() }})
                                </a> <br>
                                <small class="text-muted">
                                 {{ $taskset['user']->name }} | {{ $taskset['created_at']->diffForHumans() }}</small>
                              </li>
                            @endforeach
                          </ul>

                          Singletons: <br>
                          <ul>
                            @foreach($waitingTasks as $task)
                                <li>
                                    <a href="/admin/task/{{ $task->id }}">
                                        {{ $task->title }} ({{ $task->date }})
                                    </a>
                                    <br>
                                    <small class="text-muted"> {{ $task->user->name }} | {{ $task->created_at->diffForHumans() }}</small>
                                    <hr>
                                </li>
                            @endforeach
                          </ul>

                        </div>
                      </div>

                      <div class="col-md-7">
                        <div class="row">

                          <div class="col-md-12">
                            <h3>Vandaag</h3>

                            <div id="day">
                              @if($isWeekend)
                                Vandaag is het weekend. Geniet ervan!
                              @else
                                <bargraph :labels="{{ $daytasks['labels'] }}" :values="{{ $daytasks['values'] }}" color="rgb(255, 99, 132)" xlabel="Lesuur" ylabel="Aantal taken"></bargraph>
                              @endif
                            </div>

                          </div>
                        </div>

                        <br><br>

                        <div class="row">
                          <div class="col-md-12">
                            <h3>Weekoverzicht</h3>

                            <div id="week">
                              <bargraph :labels="{{ $weektasks['labels'] }}" :values="{{ $weektasks['values'] }}" color="orange" xlabel="Weekdag" ylabel="Aantal taken"></bargraph>
                            </div>

                          </div>
                        </div>

                      </div>
                  </div>

            </main>
          </div>
        </div>
@endsection

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/_vue.js') }}"></script>
@endsection
