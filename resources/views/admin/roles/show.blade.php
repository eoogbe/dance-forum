@extends('layouts.app')

@section('title')
Manage {{ $role->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Manage {{ $role->name }}</h2>

  <ul>
    @can('update', $role)
      <li><a href="{{ route('admin.roles.edit', compact('role')) }}">edit</a></li>
    @endcan
    @can('destroy', $role)
      <li>
        @include('common.delete', ['deletePath' => route('admin.roles.destroy', compact('role'))])
      </li>
    @endcan
  </ul>

  <section>
    <h3>Permissions</h3>
    @if ($permissions->exists())
      <ul>
        @foreach($permissions->get() as $permission)
        <li>{{ $permission->generateDisplayName() }}</li>
        @endforeach
      </ul>
    @else
      <p>No permissions</p>
    @endif
  </section>

  @can('index', App\User::class)
    <section>
      <h3>Users</h3>
      @can('updateUsers', $role)
        <p><a href="{{ route('admin.roles.editUsers', compact('role')) }}">manage users</a></p>
      @endcan

      @if ($users->isEmpty())
        <p>No users</p>
      @else
        {!! $users->links() !!}
        <ul>
          @foreach($users as $user)
            <li><a href="{{ route('admin.users.show', compact('user')) }}">{{ $user->name }}</a></li>
          @endforeach
        </ul>
        {!! $users->links() !!}
      @endif
    </section>
  @endcan
</section>
@endsection
