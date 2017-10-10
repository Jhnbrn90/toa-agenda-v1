<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Huidige week</a>
      </li>
    </ul>
        <div style="margin-right: 20px;">
          <form method="POST" action="/date/search" class="form-inline my-1 my-lg-0">
            {{ csrf_field() }}
            <input name="date" class="form-control mr-sm-1" style="width: 120px; font-family: sans-serif" type="text" placeholder="19-06-2017" aria-label="Zoeken" autofocus>
            <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Ga</button>
          </form>
        </div>
          <span clas="navbar-text" style="margin-right:10px;">
            Welkom,&nbsp;<strong> {{ Auth::user()->name }} </strong>&nbsp; (
            @admin
            <a href="/admin">Beheren</a> |
            @endadmin
            <a href="/logout">Uitloggen</a> )
          </span>
  </div>
</nav>
