@extends('layouts.app')

@section('title')
New Board
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>New Board</h2>

  <form method="post" action="{{ route('admin.boards.store') }}">
    @include('admin.boards.form')
  </form>
</section>
@endsection
