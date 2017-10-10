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
                          <h4>Accepteren</h4>
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
                      <div class="col-md-7">
                        <canvas id="myChart"></canvas>
                      </div>
                  </div>

            </main>
          </div>
        </div>


@endsection

@section ('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: ["1", "2", "3", "4", "5", "6", "7"],
            datasets: [{
                label: "Overzicht vandaag",
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45, 10, 2],
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>
@endsection
