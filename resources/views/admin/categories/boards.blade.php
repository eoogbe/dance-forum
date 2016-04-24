<ul>
  @foreach ($category->sortedBoards as $board)
    <li>
      <p><a href="{{ route('admin.boards.show', compact('board')) }}">{{ $board->name }}</a></p>
      <div>{!! Purifier::clean($board->description) !!}</div>
      <p>{{ $board->topicCount() }} {{ str_plural('topic', $board->topicCount()) }}</p>
      <p>{{ $board->postCount() }} {{ str_plural('post', $board->postCount()) }}</p>
      <p>{{ $board->viewCount() }} {{ str_plural('view', $board->viewCount()) }}</p>
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
    </li>
  @endforeach
</ul>
