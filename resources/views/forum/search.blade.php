@extends('layouts.app')

@section('title')
Search Results
@endsection

@section('content')
<section>
  <h2>Search Results for &lsquo;{{ $term }}&rsquo;</h2>

  @unless ($users->exists() || $categories->exists() || $boards->exists() || $topics->exists() || $posts->exists())
    <p>No results found</p>
  @endunless

  @if ($users->exists())
    <section>
      <h3>Users</h3>
      <ul>
        @foreach ($users->get() as $user)
          <li>
            <a href="{{ route('users.show', compact('user')) }}">
              {!! Highlighter::mark($user->name, $term) !!}
            </a>
          </li>
        @endforeach
      </ul>
    </section>
  @endif

  @if ($posts->exists())
    <section>
      <h3>Posts</h3>
      <ul>
        @foreach ($posts->get() as $post)
          <li>
            <a href="{{ Pagination::getPostUrl($post) }}">
              {!! Highlighter::mark($post->excerpt($term), $term) !!}
            </a>
          </li>
        @endforeach
      </ul>
    </section>
  @endif

  @if ($topics->exists())
    <section>
      <h3>Topics</h3>
      <ul>
        @foreach ($topics->get() as $topic)
          <li>
            <a href="{{ route('topics.show', compact('topic')) }}">
              {!! Highlighter::mark($topic->name, $term) !!}
            </a>
          </li>
        @endforeach
      </ul>
    </section>
  @endif

  @if ($boards->exists())
    <section>
      <h3>Boards</h3>
      <ul>
        @foreach ($boards->get() as $board)
          <li>
            <a href="{{ route('boards.show', compact('board')) }}">
              {!! Highlighter::mark($board->name, $term) !!}
            </a>
          </li>
        @endforeach
      </ul>
    </section>
  @endif

  @if ($categories->exists())
    <section>
      <h3>Categories</h3>
      <ul>
        @foreach ($categories->get() as $category)
          <li>
            <a href="{{ route('categories.show', compact('category')) }}">
              {!! Highlighter::mark($category->name, $term) !!}
            </a>
          </li>
        @endforeach
      </ul>
    </section>
  @endif
</section>
@endsection
