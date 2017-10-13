@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
              <h1>Overzicht</h1>

                  <div class="row">
                      <div class="col-md-5">
                        <div class="container">
                          <h4>Openstaande verzoeken</h4>

                          <ul>
                            @foreach($waitingTasks as $task)
                                <li>
                                    <a href="/admin/task/{{ $task->id }}">
                                        {{ $task->title }}
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
                              <bargraph :labels="{{ $daytasks['labels'] }}" :values="{{ $daytasks['values'] }}" color="rgb(255, 99, 132)" xlabel="Lesuur" ylabel="Aantal taken"></bargraph>
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

@include ('admin.footer')

@section ('scripts')

<script>

    // var ctx = document.getElementById('weekOverzicht').getContext('2d');
    // var chart = new Chart(ctx, {
    //     // The type of chart we want to create
    //     type: 'bar',

    //     // The data for our dataset
    //     data: {
    //         labels: week_labels_var,
    //         datasets: [{
    //             label: "Taken",
    //             backgroundColor: 'orange',
    //             borderColor: 'orange',
    //             data: week_data_var,
    //         }]
    //     },

    //     // Configuration options go here
    //     options: {
    //       scales: {
    //             yAxes: [{
    //               ticks: {
    //                 stepSize: 1
    //               },
    //               scaleLabel: {
    //                 display: true,
    //                 labelString: 'Aantal taken'
    //               }
    //             }],
    //             xAxes: [{
    //               scaleLabel: {
    //                 display: true,
    //                 labelString: 'Weekdag'
    //               }
    //             }]
    //           },
    //       legend: {
    //         display: false
    //       }
    //     }
    // });
</script>
@endsection
