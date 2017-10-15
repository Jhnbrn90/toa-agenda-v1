@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <h1>Overzicht van alle taken</h1>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Lesuur</th>
                            <th>Titel</th>
                            <th>Docent</th>
                            <th>Klas</th>
                            <th>Status</th>
                            <th>Aangevraagd</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->date }}</td>
                                <td>{{ $task->timetable_id }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->user->shortname }}</td>
                                <td>{{ $task->class }}</td>
                                <td>
                                    @if ($task->accepted === 0)
                                    <a href="/admin/task/{{ $task->id }}" class="btn btn-danger">Geweigerd</a>
                                    @elseif ($task->accepted === 1)
                                    <a href="/admin/task/{{ $task->id }}" class="btn btn-success">Geaccepteerd</a>
                                    @elseif ($task->accepted === 2)
                                    <a href="/admin/task/{{ $task->id }}" class="btn btn-warning">In afwachting</a>
                                    @endif
                                </td>
                                <td>{{ $task->updated_at->formatLocalized('%e-%m-%Y (%H:%M)') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </main>
          </div>
        </div>
@endsection


