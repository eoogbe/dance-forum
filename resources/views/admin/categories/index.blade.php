@extends('layouts.app')

@section('title')
Manage Categories
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <header>
    <h2>Manage Categories</h2>
    <p><a href="{{ route('admin.categories.create') }}">New Category</a></p>
  </header>

  <table>
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $category)
        <tr>
          <td>
            <a href="{{ route('admin.categories.show', compact('category')) }}">
              {{ $category->name }}
            </a>
          </td>
          <td><a href="{{ route('admin.categories.edit', compact('category')) }}">edit</a></td>
          <td>
            @include('common.delete', [
              'deletePath' => route('admin.categories.destroy', compact('category')),
            ])
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</section>
@endsection
