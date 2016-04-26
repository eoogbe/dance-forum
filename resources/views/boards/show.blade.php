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
  <ul>
    @foreach ($topics as $topic)
      @if (!$topic->isHidden() || (Auth::check() && Auth::user()->can('show', $topic)))
        <li>
          @if ($topic->isLocked())
            <p>locked</p>
          @endif
          @if ($topic->isPinned())
            <p>pinned</p>
          @endif
          @if ($topic->isHidden())
            <p>hidden</p>
          @endif
          @if (Auth::check() && $topic->hasNewPosts(Auth::user()))
            <p><a href="{{ Pagination::getPostUrl($topic->firstNewPost(Auth::user())) }}">new</a></p>
          @endif
          <p>@include('topics.link')</p>
          <p>
            created by
            <cite>
              <a href="{{ route('users.show', ['user' => $topic->author()]) }}">
                {{ $topic->author()->name }}
              </a>
            </cite>
          </p>
          @if ($topic->lastPost())
            <p>
              Last post
              @include('posts.link', ['post' => $topic->lastPost()])
              by
              <cite>
                <a href="{{ route('users.show', ['user' => $topic->lastPost()->author]) }}">
                  {{ $topic->lastPost()->authorName() }}
                </a>
              </cite>
            </p>
          @endif
          <p>{{ $topic->postCount() }} {{ str_plural('post', $topic->postCount()) }}</p>
          <p>{{ $topic->viewCount() }} {{ str_plural('view', $topic->viewCount()) }}</p>
        </li>
      @endcan
    @endforeach
  </ul>
  {!! $topics->links() !!}
</section>
@endsection
