<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == "admin_index" ? 'active' : ''}}" href="/admin">Verzoeken <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == "admin_tasks_all" ? 'active' : ''}}" href="/admin/tasks/all">Alles weergeven</a>
    </li>
  </ul>
</nav>
