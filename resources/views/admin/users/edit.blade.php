@extends ('admin.master')

@section ('content')

    @include ('admin.navbar')

    <form method="POST" action="/admin/users">
    <input type="hidden" name="userId" value="{{ $user->id }}">
        {{ csrf_field() }}
        {{ method_field('patch') }}


        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar-users')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <h1>Gebruiker bewerken</h1>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="name">Naam:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" autofocus>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="shortname">Afkorting:</label>
                            <input type="text" class="form-control" id="shortname" name="shortname" value="{{ $user->shortname }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                    </div>
                   <div class="col-md-2">
                       <div class="form-group">
                           <label for="userrole">Rol:</label>
                           <select name="userrole" id="userrole" class="form-control">
                                <option value="0" {{ $user->is_admin == 0 ? 'selected' : ''  }}>Leraar</option>
                                <option value="1" {{ $user->is_admin == 1 ? 'selected' : ''  }}>TOA</option>
                           </select>
                       </div>
                   </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn-success">Bijwerken</button>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <a href="/admin/user/{{ $user->id }}/delete" class="btn btn-danger" onclick="return confirm('Wil je deze gebruiker echt verwijderen?');">Gebruiker verwijderen</a>
            </main>
          </div>
        </div>
@endsection


