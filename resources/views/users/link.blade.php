@if ($user)
  <a href="{{ route('users.show', compact('user')) }}">{{ $user->name }}</a>
@else
  [deleted]
@endif
