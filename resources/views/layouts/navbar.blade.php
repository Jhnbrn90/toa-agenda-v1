<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <!-- <a class="nav-link" href="/">Huidige week</a> -->
        @if(Route::currentRouteName() == "home" OR Route::currentRouteName() == "taskDate")
          <a href="/filter" class="btn btn-outline-warning" title="Laat enkel door mij aangevraagde verzoeken zien.">Mijn overzicht</a>
        @elseif(Route::currentRouteName() == "taskFilter" OR Route::currentRouteName() == "taskFilterDate")
          <a href="/" class="btn btn-warning" title="Laat alles zien.">Mijn overzicht</a>
        @endif
      </li>
    </ul>
        <div style="margin-right: 20px;">
          <form method="POST" action="/date/search" class="form-inline my-1 my-lg-0" style="font-family: sans-serif;">
            {{ csrf_field() }}
            <input name="date-DayMonth" class="form-control mr-sm-1" style="width: 90px;" type="text" placeholder="19-6" aria-label="Zoeken" autofocus>
            <select class="form-control mr-sm-1" name="date-Year">
              <option>{{ $prevYear }}</option>
              <option selected>{{ $thisYear }}</object>
              <option>{{ $nextYear }}</option>
            </select>
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Naar datum</button>
          </form>
        </div>
          <span clas="navbar-text" style="margin-right:10px;">
            Welkom,&nbsp;<strong> {{ Auth::user()->name }} </strong>&nbsp; (
            @admin
            <a href="/admin">Beheer</a> |
            @endadmin
            <a href="/logout">Uitloggen</a> )
          </span>
  </div>
</nav>
