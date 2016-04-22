<a href="{{ route('topics.show', ['topic' => $post->topic]).'#post-'.$post->id }}">
  @include('common.time', ['datetime' => $post->created_at])
</a>
