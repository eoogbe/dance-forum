<table>
  <thead>
    <tr>
      <th scope="col">Board</th>
      <th scope="col">Topics</th>
      <th scope="col">Posts</th>
      <th scope="col">Views</th>
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
      <td>{{ $board->viewCount() }}</td>
      <td>
        <ul>
          @unless ($board->isFirst())
            <li>
              @include('admin.boards.swap_button', [
                'swapBoard' => $board->category->firstBoard(),
                'submitText' => 'first',
              ])
            </li>
            <li>
              @include('admin.boards.swap_button', [
                'swapBoard' => $board->prevBoard(),
                'submitText' => 'up',
              ])
            </li>
          @endunless
          @unless ($board->isLast())
            <li>
              @include('admin.boards.swap_button', [
                'swapBoard' => $board->nextBoard(),
                'submitText' => 'down',
              ])
            </li>
            <li>
              @include('admin.boards.swap_button', [
                'swapBoard' => $board->category->lastBoard(),
                'submitText' => 'last',
              ])
            </li>
          @endunless
          <li><a href="{{ route('admin.boards.edit', compact('board')) }}">edit</a></li>
          <li>
            @include('common.delete', [
              'deletePath' => route('admin.boards.destroy', compact('board')),
            ])
          </li>
        </ul>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
