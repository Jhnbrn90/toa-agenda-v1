<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == "admin_absence_index" ? 'active' : ''}}" href="/admin/absence">Overzicht <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == "admin_absence_create" ? 'active' : ''}}" href="/admin/absence/create">Nieuwe absentie</a>
    </li>
  </ul>
</nav>
