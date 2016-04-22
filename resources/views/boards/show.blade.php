@extends('layouts.app')

@section('title')
{{ $board->name }}
@endsection

@section('content')
<section>
  <header>
    <ol>
      @include('boards.breadcrumbs')
    </ol>
    <h2>{{ $board->name }}</h2>
    <div>{!! Purifier::clean($board->description) !!}</div>

    @if (Auth::check())
      <p><a href="{{ route('boards.topics.create', compact('board')) }}">New Topic</a></p>
    @endif
  </header>

  {!! $topics->links() !!}
  <table>
    <thead>
      <tr>
        <th scope="col">Topic</th>
        <th scope="col">Latest</th>
        <th scope="col">Posts</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($topics as $topic)
      <tr>
        <td>
          <p>@include('topics.link')</p>
          <p>created by <cite>{{ $topic->authorName() }}</cite></p>
        </td>
        <td>
          @if ($topic->lastPost())
            @include('posts.link', ['post' => $topic->lastPost()])
            by <cite>{{ $topic->lastPost()->authorName() }}</cite>
          @else
            None
          @endif
        </td>
        <td>{{ $topic->postCount() }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {!! $topics->links() !!}
</section>
@endsection
