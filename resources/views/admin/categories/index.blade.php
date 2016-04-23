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
            <ul>
              @unless ($category->isFirst())
                <li>
                  @include('admin.categories.swap_button', [
                    'swapCategory' => $firstCategory,
                    'submitText' => 'first',
                  ])
                </li>
                <li>
                  @include('admin.categories.swap_button', [
                    'swapCategory' => $category->prevCategory(),
                    'submitText' => 'up',
                  ])
                </li>
              @endunless
              @unless ($category->isLast())
                <li>
                  @include('admin.categories.swap_button', [
                    'swapCategory' => $category->nextCategory(),
                    'submitText' => 'down',
                  ])
                </li>
                <li>
                  @include('admin.categories.swap_button', [
                    'swapCategory' => $lastCategory,
                    'submitText' => 'last',
                  ])
                </li>
              @endunless
              <li><a href="{{ route('admin.categories.edit', compact('category')) }}">edit</a></li>
              <li>
                @include('common.delete', [
                  'deletePath' => route('admin.categories.destroy', compact('category')),
                ])
              </li>
            </ul>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</section>
@endsection
