<time datetime="{{ $datetime->toW3cString() }}">
  {{ isset($textMethod) ? $datetime->$textMethod() : $datetime->diffForHumans() }}
</time>
