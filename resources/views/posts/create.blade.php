@extends('layouts.app')

@section('title')
New Post
@endsection

@section('content')
<section>
  <header>
    <ol>
      @include('topics.breadcrumbs')
    </ol>
    <h2>New Post</h2>
  </header>

  <section>
    <h3>In reply to</h3>
    {!! Purifier::clean($parentPost->content) !!}
  </section>

  <form method="post" action="{{ route('topics.posts.store', compact('topic')) }}">
    {!! csrf_field() !!}

    @if ($isChild)
      <input type="hidden" name="parent_id" value="{{ $parentPost->id }}">
    @endif

    @include('common.errors')

    <ul>
      <li>
        <label>Text</label>

        <input type="hidden" name="content" value="" data-editor-text>

        <div class="editor">
          @if ($isChild)
            <blockquote>
              <footer>
                <cite>{{ $parentPost->authorName() }}</cite> said:
              </footer>
              {!! Purifier::clean($parentPost->content) !!}
            </blockquote>

            @unless (old('content'))
              <p></p>
            @endunless
          @endif
          {!! Purifier::clean(old('content')) !!}
        </div>

        @if ($errors->has('content'))
          <p role="alert">{{ $errors->first('content') }}</p>
        @endif
      </li>
    </ul>

    <button type="submit">Create Post</button>
  </form>
</section>
@endsection
