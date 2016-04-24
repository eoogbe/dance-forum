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

    @include('common.errors')

    <ul>
      <li>
        <fieldset aria-invalid="{{ var_export($errors->has('role_ids[]'), true) }}">
          <legend>Roles</legend>
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
                <label for="role-{{ $role->id }}">{{ ucfirst($role->name) }}</label>
              </li>
            @endforeach
          </ul>

          @if ($errors->has('role_ids[]'))
            <p role="alert">{{ $errors->first('role_ids[]') }}</p>
          @endif
        </fieldset>
      </li>
    </ul>

    <button type="submit">Update Roles</button>
  </form>
</section>
@endsection
