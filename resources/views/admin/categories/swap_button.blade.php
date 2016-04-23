<form method="post" action="{{ route('admin.categories.position', compact('category')) }}">
  {!! method_field('PUT') !!}
  {!! csrf_field() !!}
  <input type="hidden" name="swap_id" value="{{ $swapCategory->id }}">
  <button type="submit">{{ $submitText }}</button>
</form>
