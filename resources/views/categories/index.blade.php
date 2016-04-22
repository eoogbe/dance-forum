@extends('layouts.app')

@section('content')
<section>
  <h2>Boards</h2>

  @foreach ($categories as $category)
    <section>
      <h3>@include('categories.link')</h3>
      
      @include('categories.boards')
    </section>
  @endforeach
</section>
@endsection
