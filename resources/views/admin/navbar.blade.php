<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }}</a>
  <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item
      {{Route::currentRouteName() == "admin_index" ? 'active' : ''}}
      ">
        <a class="nav-link" href="/admin">Nieuwe aanvragen <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item
        {{Route::currentRouteName() == "admin_tasks_all" ? 'active' : ''}}
        ">
        <a class="nav-link" href="/admin/tasks/all">Alle taken</a>
      </li>
      <li class="nav-item
        {{Route::currentRouteName() == "admin_absence_index" ? 'active' : ''}}
        {{Route::currentRouteName() == "admin_absence_create" ? 'active' : ''}}
        ">
        <a class="nav-link" href="/admin/absence">Absenties</a>
      </li>
      <li class="nav-item
      {{Route::currentRouteName() == "admin_create_user" ? 'active' : ''}}
      {{Route::currentRouteName() == "admin_show_users" ? 'active' : ''}}
      ">
        <a class="nav-link" href="/admin/users/create">Gebruikers</a>
      </li>
      <li class="nav-item {{Route::currentRouteName() == "admin_settings" ? 'active' : ''}}">
        <a class="nav-link" href="/admin/settings">Instellingen</a>
      </li>
    </ul>
      <span clas="navbar-text" style="margin-right:10px; color: white;">
        Welkom,&nbsp;<strong> {{ Auth::user()->name }} </strong>&nbsp; (
        <a href="/" style="color:white;">Agenda</a> |
        <a href="/logout" style="color:white;">Uitloggen</a> )
      </span>
  </div>
</nav>
