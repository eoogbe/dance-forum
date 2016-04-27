@extends('layouts.app')

@section('title')
Edit Account Settings
@endsection

@section('content')
<section>
  <h2>Edit Account Settings</h2>

  <form method="post" action="{{ route('account.updateSettings') }}">
    {!! method_field('PUT') !!}
    {!! csrf_field() !!}

    @include('common.errors')

    <ul>
      <li>
        <label for="current-password">Current Password</label>

        <input
            type="password"
            name="current_password"
            id="current-password"
            placeholder="We need your current password to confirm your changes"
            aria-invalid="{{ var_export($errors->has('current_password'), true) }}"
            required
        >

        @if ($errors->has('current_password'))
          <p role="alert">{{ $errors->first('current_password') }}</p>
        @endif
      </li>

      <li>
        <label for="username">Username</label>

        <input
            type="text"
            name="username"
            id="username"
            value="{{ old('username') }}"
            placeholder="Leave blank if keep the same"
            aria-invalid="{{ var_export($errors->has('username'), true) }}"
            maxlength="255"
            autofocus
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
            placeholder="Leave blank if keep the same"
            aria-invalid="{{ var_export($errors->has('email'), true) }}"
            maxlength="255"
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
            placeholder="Leave blank if keep the same"
            aria-invalid="{{ var_export($errors->has('password'), true) }}"
            minlength="12"
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
        >

        @if ($errors->has('password_confirmation'))
          <p role="alert">{{ $errors->first('password_confirmation') }}</p>
        @endif
      </li>
    </ul>

    <button type="submit">Update Settings</button>
  </form>

  <section>
    <h3>Cancel Account</h3>

    <form method="post" action="{{ route('account.destroy') }}">
      {!! method_field('DELETE') !!}
      {!! csrf_field() !!}
      <button type="submit">Cancel Your Account</button>
    </form>
  </section>
</section>
@endsection
