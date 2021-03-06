{!! csrf_field() !!}

@include('common.errors')

<ul>
  <li>
    <label for="name">Name</label>

    <input
        type="text"
        name="name"
        id="name"
        value="{{ old('name', $role->name) }}"
        aria-invalid="{{ var_export($errors->has('name'), true) }}"
        maxlength="255"
        autofocus
        required
    >

    @if ($errors->has('name'))
      <p role="alert">{{ $errors->first('name') }}</p>
    @endif
  </li>
  <li>
    <input
        type="checkbox"
        name="auto_assigned"
        id="auto-assigned"
        @if (old('auto_assigned', $role->isAutoAssigned()))
          checked
        @endif
    >
    <label for="auto-assigned">Automatically Assign to All New Registered Users</label>
  </li>
  <li>
    <fieldset aria-invalid="{{ var_export($errors->has('permission_ids[]'), true) }}">
      <legend>Permissions</legend>
      <ul>
        @foreach ($permissions as $permission)
          <li>
            <input
                type="checkbox"
                name="permission_ids[]"
                id="permission-{{ $permission->id }}"
                value="{{ $permission->id }}"
                @if (in_array($permission->id, old('permission_ids[]', $role->isAllowedTo($permission->name) ? [$permission->id] : [])))
                  checked
                @endif
            >
            <label for="permission-{{ $permission->id }}">{{ $permission->generateDisplayName() }}</label>
          </li>
        @endforeach
      </ul>

      @if ($errors->has('permission_ids[]'))
        <p role="alert">{{ $errors->first('permission_ids[]') }}</p>
      @endif
    </fieldset>
  </li>
</ul>

<button type="submit">
  {{ $role->exists ? 'Update' : 'Create' }} Role
</button>
