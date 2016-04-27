@extends('layouts.app')

@section('title')
Edit Profile
@endsection

@section('content')
<section>
  <h2>Edit Profile</h2>

  <form method="post" action="{{ route('account.updateProfile') }}">
    {!! method_field('PUT') !!}
    {!! csrf_field() !!}

    @include('common.errors')

    <ul>
      <li>
        <label for="pronouns">Appropriate Gender Pronouns</label>

        <input
            type="text"
            name="pronouns"
            id="pronouns"
            value="{{ old('pronouns', Auth::user()->pronouns) }}"
            placeholder="e.g. she/her, he/him, they/them"
            aria-invalid="{{ var_export($errors->has('pronouns'), true) }}"
            maxlength="255"
            autofocus
        >

        @if ($errors->has('pronouns'))
          <p role="alert">{{ $errors->first('pronouns') }}</p>
        @endif
      </li>
      <li>
        <label>About You</label>

        <input type="hidden" name="description" value="" data-editor-text>

        <div class="editor">{!! Purifier::clean(old('description', Auth::user()->description)) !!}</div>

        @if ($errors->has('description'))
          <p role="alert">{{ $errors->first('description') }}</p>
        @endif
      </li>
    </ul>

    <button type="submit">Update Profile</button>
  </form>
</section>
@endsection
