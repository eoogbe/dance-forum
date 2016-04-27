@extends('layouts.app')

@section('title')
New Topic
@endsection

@section('content')
<section>
  <header>
    <ol>
      @include('boards.breadcrumbs')
    </ol>
    <h2>New Topic</h2>
  </header>

  <form method="post" action="{{ route('boards.topics.store', compact('board')) }}">
    {!! csrf_field() !!}

    @include('common.errors')

    <ul>
      <li>
        <label for="name">Name</label>

        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name') }}"
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
        <label>First Post</label>

        <input type="hidden" name="post_content" value="" data-editor-text>

        <div class="editor">{{ old('post_content') }}</div>

        @if ($errors->has('post_content'))
          <p role="alert">{{ $errors->first('post_content') }}</p>
        @endif
      </li>
    </ul>

    <button type="submit">Create Topic</button>
  </form>
</section>
@endsection
