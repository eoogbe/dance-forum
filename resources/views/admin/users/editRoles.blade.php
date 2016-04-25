@extends('layouts.app')

@section('title')
Edit Roles for {{ $user->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Edit Roles for {{ $user->name }}</h2>

  <form method="post" action="{{ route('admin.users.updateRoles', compact('user')) }}">
    {!! method_field('PUT') !!}
    {!! csrf_field() !!}

    <ul>
      @foreach ($roles as $role)
        <li>
          <input
              type="checkbox"
              name="role_ids[]"
              id="role-{{ $role->id }}"
              value="{{ $role->id }}"
              @if (in_array($role->id, old('role_ids[]', $user->roles()->getRelatedIds()->toArray())))
                checked
              @endif
          >
          <label for="role-{{ $role->id }}">{{ $role->name }}</label>
        </li>
      @endforeach
    </ul>

    <button type="submit">Update Roles</button>
  </form>
</section>
@endsection
