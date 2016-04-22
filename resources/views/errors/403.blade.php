@extends('layouts.app')

@section('title')
Access denied
@endsection

@section('content')
<section>
  <h2>Access denied</h2>
  <p>
    You are not authorized to access this page.
    @if (Auth::guest())
      You may need to <a href="{{ url('/login') }}">login</a>.
    @endif
  </p>
  <p>Go to <a href="{{ url('/') }}">homepage</a>.</p>
</section>
@endsection
