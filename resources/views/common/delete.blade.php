<form method="post" action="{{ $deletePath }}">
  {!! method_field('DELETE') !!}
  {!! csrf_field() !!}
  <button type="submit">delete</button>
</form>
