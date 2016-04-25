@extends('layouts.app')

@section('title')
Manage Users
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Manage Users</h2>

  {!! $users->links() !!}
  <ul>
    @foreach ($users as $user)
      <li>
        <a href="{{ route('admin.users.show', compact('user')) }}">{{ $user->name }}</a>
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
      </li>
    @endforeach
  </ul>
  {!! $users->links() !!}
</section>
@endsection
