<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="#">Beheer</a>
  <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Overzicht <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Gebruikers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Instellingen</a>
      </li>
    </ul>
      <span clas="navbar-text" style="margin-right:10px; color: white;">
        Welkom,&nbsp;<strong> {{ Auth::user()->name }} </strong>&nbsp; (
        <a href="/admin" style="color:white;">Agenda</a> |
        <a href="/logout" style="color:white;">Uitloggen</a> )
      </span>
  </div>
</nav>
