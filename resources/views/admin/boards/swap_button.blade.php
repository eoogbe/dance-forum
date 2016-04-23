<form method="post" action="{{ route('admin.boards.position', compact('board')) }}">
  {!! method_field('PUT') !!}
  {!! csrf_field() !!}
  <input type="hidden" name="swap_id" value="{{ $swapBoard->id }}">
  <button type="submit">{{ $submitText }}</button>
</form>
