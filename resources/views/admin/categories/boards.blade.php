<table>
  <thead>
    <tr>
      <th scope="col">Board</th>
      <th scope="col">Topics</th>
      <th scope="col">Posts</th>
      <th scope="col">Settings</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($category->sortedBoards as $board)
    <tr>
      <td>
        <p><a href="{{ route('admin.boards.show', compact('board')) }}">{{ $board->name }}</a></p>
        <div>{!! Purifier::clean($board->description) !!}</div>
      </td>
      <td>{{ $board->topicCount() }}</td>
      <td>{{ $board->postCount() }}</td>
      <td>
        <form method="post" action="{{ route('admin.boards.position', compact('board')) }}">
          {!! method_field('PUT') !!}
          {!! csrf_field() !!}
          @unless ($board->isFirst())
            <button name="first" type="submit">first</button>
            <button name="up" type="submit">up</button>
          @endunless
          @unless ($board->isLast())
            <button name="down" type="submit">down</button>
            <button name="last" type="submit">last</button>
          @endunless
        </form>
        <a href="{{ route('admin.boards.edit', compact('board')) }}">edit</a>
        @include('common.delete', [
          'deletePath' => route('admin.boards.destroy', compact('board')),
        ])
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
