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
        <th scope="col">Settings</th>
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
          <td>
            <form method="post" action="{{ route('admin.categories.position', compact('category')) }}">
              {!! method_field('PUT') !!}
              {!! csrf_field() !!}
              @unless ($category->isFirst())
                <button name="first" type="submit">first</button>
                <button name="up" type="submit">up</button>
              @endunless
              @unless ($category->isLast())
                <button name="down" type="submit">down</button>
                <button name="last" type="submit">last</button>
              @endunless
            </form>
            <a href="{{ route('admin.categories.edit', compact('category')) }}">edit</a>
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
