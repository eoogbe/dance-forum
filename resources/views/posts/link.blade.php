<a href="{{ Pagination::getPostUrl($post) }}">
  @include('common.time', ['datetime' => $post->created_at])
</a>
