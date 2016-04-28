@extends('layouts.app')

@section('title')
Manage {{ $user->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Manage {{ $user->name }}</h2>
  <p>
    Registered at
    @include('common.time', [
      'datetime' => $user->created_at,
      'textMethod' => 'toDayDateTimeString',
    ])
  </p>
  @if ($user->login_at)
    <p>Last active @include('common.time', ['datetime' => $user->login_at])</p>
  @endif
  <p>{{ $user->postCount() }} {{ str_plural('post', $user->postCount()) }}</p>

  <ul>
    <li><a href="{{ route('users.show', compact('user')) }}">view profile</a></li>
    @can('ban', $user)
      @if ($user->blockedStatus)
        <li>
          <form method="post" action="{{ route('admin.users.ban', compact('user')) }}">
            {!! csrf_field() !!}
            <button type="submit">remove ban</button>
          </form>
        </li>
      @else
        <li>
          <form method="post" action="{{ route('admin.users.ban', compact('user')) }}">
            {!! csrf_field() !!}
            <input type="hidden" name="blocked_status" value="banned">
            <button type="submit">ban</button>
          </form>
        </li>
        <li>
          <form method="post" action="{{ route('admin.users.ban', compact('user')) }}">
            {!! csrf_field() !!}
            <input type="hidden" name="blocked_status" value="shadow banned">
            <button type="submit">shadow ban</button>
          </form>
        </li>
      @endif
    @endcan
  </ul>

  <section>
    <h3>User Permissions</h3>
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

  @can('index', App\Role::class)
    <section>
      <h3>Roles</h3>
      @can('updateRoles', $user)
        <p><a href="{{ route('admin.users.editRoles', compact('user')) }}">manage roles</a></p>
      @endcan
      @if ($roles->isEmpty())
        <p>No roles</p>
      @else
        <ul>
          @foreach($roles as $role)
            <li>
              <a href="{{ route('admin.roles.show', compact('role')) }}">{{ $role->name }}</a>
            </li>
          @endforeach
        </ul>
      @endif
    </section>
  @endcan
</section>
@endsection
