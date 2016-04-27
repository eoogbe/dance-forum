@extends('layouts.app')

@section('title')
{{ $user->name }}
@endsection

@section('content')
<section>
  <header>
    <h2>{{ $user->name }}</h2>
    @can ('update', $user)
      <ul>
        <li><a href="{{ route('account.editProfile') }}">edit profile</a></li>
        <li><a href="{{ route('subscriptions.edit') }}">edit subscriptions</a></li>
        <li><a href="{{ route('account.editSettings') }}">edit account settings</a></li>
      </ul>
    @endcan
  </header>

  @if ($user->pronouns)
    <p>{{ $user->pronouns }} pronouns</p>
  @endif
  @if ($user->description)
    <div>{!! Purifier::clean($user->description) !!}</div>
  @endif
  <p>
    Registered at
    @include('common.time', [
      'datetime' => $user->created_at,
      'textMethod' => 'toDayDateTimeString',
    ])
  </p>
  @if ($user->login_at)
    <p>Last active @include('common.time', ['datetime' => $user->login_at])</p>
  @endif
  <p>{{ $user->postCount() }} {{ str_plural('post', $user->postCount()) }}</p>

  <section>
    <h3>Subscriptions</h3>
    @if ($user->subscriptions()->exists())
      <ul>
        @foreach ($user->subscriptions as $subscription)
          <li>
            @include('topics.link', ['topic' => $subscription->topic])
          </li>
        @endforeach
      </ul>
    @else
      <p>None</p>
    @endif
  </section>
</section>
@endsection
