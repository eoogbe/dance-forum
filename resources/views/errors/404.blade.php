@extends('layouts.app')

@section('title')
Page not found
@endsection

@section('content')
<section>
  <h2>Page not found</h2>
  <p>The page you were looking for could not be found.</p>
  <p>Go to <a href="{{ url('/') }}">homepage</a>.</p>
</section>
@endsection
