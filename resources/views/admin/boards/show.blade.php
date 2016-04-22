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

  <dl>
    <dt>Category</dt>
    <dd>
      <a href="{{ route('admin.categories.show', ['category' => $board->category]) }}">
        {{ $board->category->name }}
      </a>
    </dd>
  </dl>

  <div>{!! Purifier::clean($board->description) !!}</div>


  <ul>
    <li><a href="{{ route('boards.show', compact('board')) }}">view on forum</a></li>
    <li><a href="{{ route('admin.boards.edit', compact('board')) }}">edit</a></li>
    <li>
      @include('common.delete', ['deletePath' => route('admin.boards.destroy', compact('board'))])
    </li>
  </ul>
</section>
@endsection
