@extends('layouts.app')

@section('title')
Register
@endsection

@section('content')
<section>
  <h2>Register</h2>

  <form method="post" action="{{ url('/register') }}">
    {!! csrf_field() !!}

    @include('common.errors')

    <ul>
      <li>
        <label for="username">Username</label>

        <input
            type="text"
            name="username"
            id="username"
            value="{{ old('username') }}"
            aria-invalid="{{ var_export($errors->has('username'), true) }}"
            maxlength="255"
            autofocus
            required
        >

        @if ($errors->has('username'))
          <p role="alert">{{ $errors->first('username') }}</p>
        @endif
      </li>

      <li>
        <label for="email">Email</label>

        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email') }}"
            aria-invalid="{{ var_export($errors->has('email'), true) }}"
            maxlength="255"
            required
        >

        @if ($errors->has('email'))
          <p role="alert">{{ $errors->first('email') }}</p>
        @endif
      </li>

      <li>
        <label for="password">Password</label>

        <input
            type="password"
            name="password"
            id="password"
            aria-invalid="{{ var_export($errors->has('password'), true) }}"
            minlength="12"
            required
        >

        @if ($errors->has('password'))
          <p role="alert">{{ $errors->first('password') }}</p>
        @endif
      </li>

      <li>
        <label for="password-confirmation">Confirm Password</label>

        <input
            type="password"
            name="password_confirmation"
            id="password-confirmation"
            aria-invalid="{{ var_export($errors->has('password_confirmation'), true) }}"
            required
        >

        @if ($errors->has('password_confirmation'))
          <p role="alert">{{ $errors->first('password_confirmation') }}</p>
        @endif
      </li>
    </ul>

    <button type="submit">Register</button>
  </form>
</section>
@endsection
