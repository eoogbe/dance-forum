@extends('layouts.app')

@section('title')
Edit Post
@endsection

@section('content')
<section>
  <header>
    <ol>
      @include('posts.breadcrumbs')
    </ol>
    <h2>Edit Post</h2>
  </header>

  <form method="post" action="{{ route('posts.update', compact('post')) }}">
    {!! method_field('PUT') !!}
    {!! csrf_field() !!}

    @include('common.errors')

    <ul>
      <li>
        <label>Text</label>

        <input type="hidden" name="content" value="" data-editor-text>

        <div class="editor">
          {!! Purifier::clean(old('content', $post->content)) !!}
        </div>

        @if ($errors->has('content'))
          <p role="alert">{{ $errors->first('content') }}</p>
        @endif
      </li>
    </ul>

    <button type="submit">Update Post</button>
  </form>

  <p>
    Back to
    <a href="{{ route('topics.show', ['topic' => $post->topic]).'#post-'.$post->id }}">post</a>
  </p>
</section>
@endsection
