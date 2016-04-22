@extends('layouts.app')

@section('title')
Login
@endsection

@section('content')
<section>
  <h2>Login</h2>

  <form method="post" action="{{ url('/login') }}">
    {!! csrf_field() !!}

    @if (count($errors) > 0)
      <p role="alert">Invalid email/password combination</p>
    @endif

    <ul>
      <li>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" autofocus>
      </li>

      <li>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
      </li>

      <li>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember Me</label>
      </li>
    </ul>

    <button type="submit">Login</button>
    <a href="{{ url('/password/reset') }}">Forgot Your Password?</a>
  </form>
</section>
@endsection
