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
      <li>
        @can('addPost', $topic)
          <a href="{{ route('topics.posts.create', compact('topic')) }}">reply</a>
        @endcan
      </li>
      @can('updatePermissions', $topic)
        <li>
          <a href="{{ route('admin.topics.editPermissions', compact('topic')) }}">
            manage permissions
          </a>
        </li>
      @endcan
      @can('update', $topic)
        <li><a href="{{ route('admin.topics.edit', compact('topic')) }}">edit</a></li>
      @endcan
      @can('destroy', $topic)
        <li>
          @include('common.delete', [
            'deletePath' => route('admin.topics.destroy', compact('topic')),
          ])
        </li>
      @endcan
      @can('lock', $topic)
        <li>
          @if ($topic->isLocked())
            <form method="post" action="{{ route('admin.topics.unlock', compact('topic')) }}">
              {!! csrf_field() !!}
              <button type="submit">unlock</button>
            </form>
          @else
            <form method="post" action="{{ route('admin.topics.lock', compact('topic')) }}">
              {!! csrf_field() !!}
              <button type="submit">lock</button>
            </form>
          @endif
        </li>
      @endcan
      @can('pin', $topic)
        <li>
          @if ($topic->isPinned())
            <form method="post" action="{{ route('admin.topics.unpin', compact('topic')) }}">
              {!! csrf_field() !!}
              <button type="submit">unpin</button>
            </form>
          @else
            <form method="post" action="{{ route('admin.topics.pin', compact('topic')) }}">
              {!! csrf_field() !!}
              <button type="submit">pin</button>
            </form>
          @endif
        </li>
      @endcan
      @can('hide', $topic)
        <li>
          @if ($topic->isHidden())
            <form method="post" action="{{ route('admin.topics.unhide', compact('topic')) }}">
              {!! csrf_field() !!}
              <button type="submit">show</button>
            </form>
          @else
            <form method="post" action="{{ route('admin.topics.hide', compact('topic')) }}">
              {!! csrf_field() !!}
              <button type="submit">hide</button>
            </form>
          @endif
        </li>
      @endcan
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
                @can('addPost', $topic)
                  <li>
                    <a href="{{ route('topics.posts.create', ['topic' => $topic, 'parent_id' => $post->id]) }}">
                      reply
                    </a>
                  </li>
                @endcan
                @can('update', $post)
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
