@extends('layouts.app')

@section('title')
Manage Boards
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <header>
    <h2>Manage Boards</h2>
    @can('store', App\Board::class)
      <p><a href="{{ route('admin.boards.create') }}">New Board</a></p>
    @endcan
  </header>

  @foreach ($categories as $category)
    <section>
      <h3>
        <a href="{{ route('admin.categories.show', compact('category')) }}">
          {{ $category->name }}
        </a>
      </h3>

      @include('admin.categories.boards')
    </section>
  @endforeach
</section>
@endsection
