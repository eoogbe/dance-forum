@extends('layouts.app')

@section('title')
Manage {{ $board->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Manage {{ $board->name }}</h2>
  <div>{!! Purifier::clean($board->description) !!}</div>

  <p>
    In
    <a href="{{ route('admin.categories.show', ['category' => $board->category]) }}">
      {{ $board->category->name }}
    </a>
  </p>

  <ul>
    <li><a href="{{ route('boards.show', compact('board')) }}">view on forum</a></li>
    @can('update', $board)
      <li><a href="{{ route('admin.boards.edit', compact('board')) }}">edit</a></li>
    @endcan
    @can('destroy', $board)
      <li>
        @include('common.delete', ['deletePath' => route('admin.boards.destroy', compact('board'))])
      </li>
    @endcan
  </ul>
</section>
@endsection
