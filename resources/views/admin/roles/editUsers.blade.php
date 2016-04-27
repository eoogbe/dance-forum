@extends('layouts.app')

@section('title')
Edit Users for {{ $role->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Edit Users for {{ $role->name }}</h2>

  <form method="post" action="{{ route('admin.roles.updateUsers', compact('role')) }}">
    {!! method_field('PUT') !!}
    {!! csrf_field() !!}

    <ul>
      @foreach ($users as $user)
        <li>
          <input
              type="checkbox"
              name="user_ids[]"
              id="user-{{ $user->id }}"
              value="{{ $user->id }}"
              @if (in_array($user->id, old('user_ids[]', $role->users()->getRelatedIds()->toArray())))
                checked
              @endif
          >
          <label for="user-{{ $user->id }}">{{ $user->name }}</label>
        </li>
      @endforeach
    </ul>

    <button type="submit">Update Users</button>
  </form>

  <p>Back to <a href="{{ route('admin.roles.show', compact('role')) }}">role</a></p>
</section>
@endsection
