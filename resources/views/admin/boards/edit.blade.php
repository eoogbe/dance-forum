@extends('layouts.app')

@section('title')
Edit {{ $board->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Edit {{ $board->name }}</h2>

  <form method="post" action="{{ route('admin.boards.update', compact('board')) }}">
    {!! method_field('PUT') !!}
    @include('admin.boards.form')
  </form>
</section>
@endsection
