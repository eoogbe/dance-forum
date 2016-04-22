@extends('layouts.app')

@section('title')
Reset Password
@endsection

@section('content')
<section>
  <h2>Reset Password</h2>

  <form method="post" action="{{ url('/password/reset') }}">
    {!! csrf_field() !!}

    @include('common.errors')

    <input type="hidden" name="token" value="{{ $token }}">

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

    <button type="submit">Reset Password</button>
  </form>
</section>
@endsection
