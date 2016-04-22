@extends('layouts.app')

@section('title')
{{ $topic->name }}
@endsection

@section('content')
<section>
  <header>
    <ol>
      @include('topics.breadcrumbs')
    </ol>
    <h2>{{ $topic->name }}</h2>

    <ul>
      @if (Auth::check())
        <li><a href="{{ route('topics.posts.create', compact('topic')) }}">reply</a></li>
      @endif

      @role('admin')
        <li><a href="{{ route('admin.topics.edit', compact('topic')) }}">edit</a></li>
        <li>
          @include('common.delete', [
            'deletePath' => route('admin.topics.destroy', compact('topic')),
          ])
        </li>
      @endif
    </ul>
  </header>

  {!! $posts->links() !!}
  <ol>
    @foreach ($posts as $post)
      <li id="post-{{ $post->id }}">
        <article>
          <footer>
            <p><cite>{{ $post->authorName() }}</cite></p>
            <p>@include('posts.link')</p>
            @unless ($post->trashed())
              @if ($post->isUpdated())
                <p>edited</p>
              @endif
              @if ($post->parentPost)
                <p>
                  in reply to
                  <a href="#post-{{ $post->parent_id }}">
                    {{ $post->parentPost->authorName() }}
                  </a>
                </p>
              @endif
            @endunless
            <ul>
              @if ($post->trashed())
                @can('restore', $post)
                  <li>
                    <form method="post" action="{{ route('posts.restore', ['id' => $post->id]) }}">
                      {!! csrf_field() !!}
                      <button type="submit">restore</button>
                    </form>
                  </li>
                @endcan
              @else
                <li>
                  <a href="{{ route('topics.posts.create', ['topic' => $topic, 'parent_id' => $post->id]) }}">
                    reply
                  </a>
                </li>
                @can('edit', $post)
                  <li><a href="{{ route('posts.edit', compact('post')) }}">edit</a></li>
                @endcan
                @can('destroy', $post)
                  <li>
                    @include('common.delete', [
                      'deletePath' => route('posts.destroy', compact('post')),
                    ])
                  </li>
                @endcan
              @endif
            </ul>
          </footer>
          @if ($post->trashed())
            [deleted]
          @else
            {!! Purifier::clean($post->content) !!}
          @endif
        </article>
      </li>
    @endforeach
  </ol>
  {!! $posts->links() !!}
</section>
@endsection
