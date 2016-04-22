@extends('layouts.app')

@section('title')
New Category
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>New Category</h2>

  <form method="post" action="{{ route('admin.categories.store') }}">
    @include('admin.categories.form')
  </form>
</section>
@endsection
