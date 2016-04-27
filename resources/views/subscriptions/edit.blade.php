@extends('layouts.app')

@section('title')
Edit Subscriptions
@endsection

@section('content')
<section>
  <h2>Edit Subscriptions</h2>

  <form method="post" action="{{ route('subscriptions.update') }}">
    {!! method_field('PUT') !!}
    {!! csrf_field() !!}

    <ul>
      @foreach (Auth::user()->subscriptions as $subscription)
        <li>
          <input
              type="checkbox"
              name="topic_ids[]"
              id="topic-{{ $subscription->topic_id }}"
              value="{{ $subscription->topic_id }}"
              @if (in_array($subscription->topic_id, old('topic_ids[]', [$subscription->topic_id])))
                checked
              @endif
          >
          <label for="topic-{{ $subscription->topic_id }}">{{ $subscription->topic->name }}</label>
        </li>
      @endforeach
    </ul>

    <button type="submit">Update Subscriptions</button>
  </form>
</section>
@endsection
