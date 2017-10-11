<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == "admin_create_user" ? 'active' : ''}}" href="/admin/users/create">Nieuwe gebruiker <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == "admin_show_users" ? 'active' : ''}}" href="/admin/users/manage">Beheer gebruikers</a>
    </li>
  </ul>
</nav>
