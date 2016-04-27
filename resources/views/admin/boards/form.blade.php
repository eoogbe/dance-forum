{!! csrf_field() !!}

@include('common.errors')

<ul>
  <li>
    <label for="name">Name</label>

    <input
        type="text"
        name="name"
        id="name"
        value="{{ old('name', $board->name) }}"
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
    <label>Description</label>

    <input type="hidden" name="description" value="" data-editor-text>

    <div class="editor">{!! Purifier::clean(old('description', $board->description)) !!}</div>

    @if ($errors->has('description'))
      <p role="alert">{{ $errors->first('description') }}</p>
    @endif
  </li>
  <li>
    <label for="category-id">Category</label>

    <select
        name="category_id"
        id="category-id"
        aria-invalid="{{ var_export($errors->has('category_id'), true) }}"
        required
    >
      @foreach($categories as $category)
        <option
            value="{{ $category->id }}"
            @if ($category->hasBoard($board))
              selected
            @endif
        >
          {{ $category->name }}
        </option>
      @endforeach
    </select>

    @if ($errors->has('category_id'))
      <p role="alert">{{ $errors->first('category_id') }}</p>
    @endif
  </li>
</ul>

<button type="submit">
  {{ $board->exists ? 'Update' : 'Create' }} Board
</button>
