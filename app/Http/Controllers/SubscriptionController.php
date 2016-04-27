<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Topic;
use App\Http\Requests;

class SubscriptionController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, Topic $topic)
  {
    $request->user()->subscribeTo($topic);

    return redirect()->route('topics.show', compact('topic'));
  }

  /**
   * Show the form for editing the resource.
   *
   * @param  Post  $post
   * @return \Illuminate\Http\Response
   */
  public function edit()
  {
    return view('subscriptions.edit');
  }

  /**
   * Update the resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $user = $request->user();
    $user->subscriptions()->whereNotIn('topic_id', $request->topic_ids ?: [])->delete();

    return redirect()->route('users.show', compact('user'));
  }

  /**
   * Remove the resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, Topic $topic)
  {
    $request->user()->subscriptions()->where('topic_id', $topic->id)->delete();

    return redirect()->route('topics.show', compact('topic'));
  }
}
