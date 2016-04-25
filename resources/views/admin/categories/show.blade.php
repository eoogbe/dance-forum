@extends('layouts.app')

@section('title')
Manage {{ $category->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <header>
    <h2>Manage {{ $category->name }}</h2>

    <ul>
      <li><a href="{{ route('categories.show', compact('category')) }}">view on forum</a></li>
      @can('update', $category)
        <li><a href="{{ route('admin.categories.edit', compact('category')) }}">edit</a></li>
      @endcan
      @can('destroy', $category)
        <li>
          @include('common.delete', ['deletePath' => route('admin.categories.destroy', compact('category'))])
        </li>
      @endcan
    </ul>
  </header>

  @include('admin.categories.boards')
</section>
@endsection
