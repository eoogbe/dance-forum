@extends('layouts.app')

@section('title')
{{ $category->name }}
@endsection

@section('content')
<section>
  <header>
    <ol>
      @include('categories.breadcrumbs')
    </ol>
    <h2>{{ $category->name }}</h2>
  </header>

  @include('categories.boards')
</section>
@endsection
