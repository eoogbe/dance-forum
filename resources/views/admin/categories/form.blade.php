{!! csrf_field() !!}

@include('common.errors')

<ul>
  <li>
    <label for="name">Name</label>

    <input
        type="text"
        name="name"
        id="name"
        value="{{ old('name', $category->name) }}"
        aria-invalid="{{ var_export($errors->has('name'), true) }}"
        maxlength="255"
        autofocus
        required
    >

    @if ($errors->has('name'))
      <p role="alert">{{ $errors->first('name') }}</p>
    @endif
  </li>
</ul>

<button type="submit">
  {{ $category->exists ? 'Update' : 'Create' }} Category
</button>
