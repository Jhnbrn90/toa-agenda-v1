@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar-users')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <h1>Overzicht gebruikers</h1>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Afkorting</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aangemaakt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->shortname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>@if($user->is_admin == 1) TOA @else Docent @endif</td>
                                <td>{{ Carbon\Carbon::parse($user->created_at)->format('d-m-Y (h:i)') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </main>
          </div>
        </div>
@endsection


