<ul>
  @foreach ($category->sortedBoards as $board)
    <li>
      <p>@include('boards.link')</p>
      <div>{!! Purifier::clean($board->description) !!}</div>
      @if ($board->lastPost())
        <p>
          Last post
          @include('posts.link', ['post' => $board->lastPost()])
          by
          <cite>
            @include('users.link', ['user' => $board->lastPost()->author])
          </cite>
          in @include('topics.link', ['topic' => $board->lastPost()->topic])
        </p>
      @endif
      <p>{{ $board->topicCount() }} {{ str_plural('topic', $board->topicCount()) }}</p>
      <p>{{ $board->postCount() }} {{ str_plural('post', $board->postCount()) }}</p>
      <p>{{ $board->viewCount() }} {{ str_plural('view', $board->viewCount()) }}</p>
    </li>
  @endforeach
</ul>
