<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">TOA Agenda</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      @if(Auth::check())
      <li class="nav-item">
        <a class="nav-link" href="/datum/{{ $date_back }}">Week terug</a>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" href="/">Huidige week <span class="sr-only">(current)</span></a>
      </li>
      @if(Auth::check())
      <li class="nav-item">
        <a class="nav-link" href="/datum/{{ $date_forward }}">Week vooruit</a>
      </li>
      @endif
    </ul>
      @if(Auth::check())
        <div style="margin-right: 20px;">
          <form method="GET" action="{{ route('home')}}" class="form-inline my-1 my-lg-0">
            <input name="datum" class="form-control mr-sm-1" style="width: 120px; font-family: sans-serif" type="text" placeholder="19-06-2019" aria-label="Zoeken" autofocus>
            <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Ga</button>
          </form>
        </div>

          <span clas="navbar-text" style="margin-right:10px;">
            Welkom,&nbsp;<strong> {{ Auth::user()->name }} </strong>&nbsp;(<a href="/logout">Uitloggen</a>)
          </span>
      @endif
  </div>
</nav>
