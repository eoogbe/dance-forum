@extends('layouts.app')

@section('title')
Edit {{ $category->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Edit {{ $category->name }}</h2>

  <form method="post" action="{{ route('admin.categories.update', compact('category')) }}">
    {!! method_field('PUT') !!}
    @include('admin.categories.form')
  </form>

  <p>Back to <a href="{{ route('admin.categories.show', compact('category')) }}">category</a></p>
</section>
@endsection
