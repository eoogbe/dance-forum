@extends('layouts.app')

@section('title')
Send Reset Password Email
@endsection

@section('content')
<section>
  <h2>Send Reset Password Email</h2>

  @if (session('status'))
    <p role="alert">{{ session('status') }}</p>
  @endif

  <form method="post" action="{{ url('/password/email') }}">
    {!! csrf_field() !!}

    @include('common.errors')

    <ul>
      <li>
        <label for="email">Email</label>

        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email') }}"
            aria-invalid="{{ var_export($errors->has('email'), true) }}"
            maxlength="255"
            autofocus
            required
        >

        @if ($errors->has('email'))
          <p role="alert">{{ $errors->first('email') }}</p>
        @endif
      </li>
    </ul>

    <button type="submit">Send Reset Password Email</button>
  </form>
</section>
@endsection
