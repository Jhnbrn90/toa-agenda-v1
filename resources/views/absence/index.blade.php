@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar-absence')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
              @include ('layouts.flash')
              <h1>Absenties</h1>
              <div class="container" style="padding-top:10px;">
                <table class="table table-striped table-hover">
                  <thead>
                    <th>Datum</th>
                    <th>Lesuur</th>
                    <th>Reden</th>
                    <th>&nbsp;</th>
                  </thead>
                  <tbody>
                      @foreach ($absence_table as $absence)

                      <form method="POST" action="/admin/absence/{{ $absence->id }}/delete">
                        <tr>
                          <td> {{ $absence->date }} </td>
                          <td>
                            <ul>
                            @foreach (explode(', ', $absence->school_hour) as $school_hour)
                              <li>{{ $school_hour }}</li>
                            @endforeach
                            </ul>
                          </td>
                          <td> {{ $absence->message }} </td>
                          <td> <a href="/admin/absence/edit/{{ $absence->id }}" class="btn btn-primary text-white">Bewerken</a>

                              {{ csrf_field() }}
                              {{ method_field('delete') }}
                              &nbsp; <button class="btn btn-danger" type="submit" style="cursor: pointer">Verwijderen</button>
                        </td>
                        </tr>
                        </form>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </main>
          </div>
        </div>
@endsection
