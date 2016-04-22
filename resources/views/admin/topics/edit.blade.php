@extends('layouts.app')

@section('title')
Edit {{ $topic->name }}
@endsection

@section('content')
<section>
  <header>
    <ol>
      @include('topics.breadcrumbs')
    </ol>
    <h2>Edit {{ $topic->name }}</h2>
  </header>

  <form method="post" action="{{ route('admin.topics.update', compact('topic')) }}">
    {!! method_field('PUT') !!}
    {!! csrf_field() !!}

    @include('common.errors')

    <ul>
      <li>
        <label for="name">Name</label>

        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $topic->name) }}"
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

    <button type="submit">Update Topic</button>
  </form>

  <p>Back to <a href="{{ route('topics.show', compact('topic')) }}">topic</a></p>
</section>
@endsection
