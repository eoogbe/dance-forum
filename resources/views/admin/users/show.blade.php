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

  <section>
    <h3>Roles</h3>
    <p><a href="{{ route('admin.users.editRoles', compact('user')) }}">manage roles</a></p>
    <ul>
      @foreach($user->roles as $role)
        <li>{{ ucfirst($role->name) }}</li>
      @endforeach
    </ul>
  </section>
</section>
@endsection
