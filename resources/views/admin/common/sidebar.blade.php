<nav>
  <h3>Forum Management</h3>
  <ul>
    @can('index', App\Board::class)
      <li><a href="{{ route('admin.boards.index') }}">Boards</a></li>
      <li><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    @endcan
    @can('index', App\User::class)
      <li><a href="{{ route('admin.users.index') }}">Users</a></li>
    @endcan
    @can('index', App\Role::class)
      <li><a href="{{ route('admin.roles.index') }}">Roles</a></li>
    @endcan
  </ul>
</nav>
