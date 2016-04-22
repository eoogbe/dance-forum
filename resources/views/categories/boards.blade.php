<table>
  <thead>
    <tr>
      <th scope="col">Board</th>
      <th scope="col">Latest</th>
      <th scope="col">Topics</th>
      <th scope="col">Posts</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($category->sortedBoards as $board)
    <tr>
      <td>
        <p>@include('boards.link')</p>
        <div>{!! Purifier::clean($board->description) !!}</div>
      </td>
      <td>
        @if ($board->lastPost())
          @include('posts.link', ['post' => $board->lastPost()])
          by <cite>{{ $board->lastPost()->authorName() }}</cite>
          in @include('topics.link', ['topic' => $board->lastPost()->topic])
        @else
          None
        @endif
      </td>
      <td>{{ $board->topicCount() }}</td>
      <td>{{ $board->postCount() }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
