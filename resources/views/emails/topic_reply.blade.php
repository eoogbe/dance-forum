<html>
  <body>
    <h1>A topic you have subscribed to has received a reply</h1>

    <p>
      <a href="{{ Pagination::getPostUrl($post) }}">
        View {{ $post->authorName() }}'s reply to {{ $post->topic->name }}
      </a>
    </p>

    <p>
      <a href="{{ route('topics.subscriptions.destroy', ['topic' => $post->topic]) }}">
        Unsubscribe from {{ $post->topic->name }}
      </a>
    </p>
  </body>
</html>
