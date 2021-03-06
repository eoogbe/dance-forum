<?php

namespace App\Http\Controllers;

use Mail;
use Pagination;
use Illuminate\Http\Request;

use App\Topic;
use App\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
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
   * Show the form for creating a new resource.
   *
   * @param \Illuminate\Http\Request $request
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request, Topic $topic)
  {
    $this->authorize('addPost', $topic);

    $parentPost = $topic->posts()->find($request->input('parent_id'));

    return view('posts.create', [
      'topic' => $topic,
      'parentPost' => $parentPost ?: $topic->firstPost(),
      'isChild' => !is_null($parentPost),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  PostRequest  $request
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function store(PostRequest $request, Topic $topic)
  {
    $user = $request->user();

    $post = $user->posts()->create([
      'topic_id' => $topic->id,
      'content' => $request->content,
      'parent_id' => $request->parent_id,
    ]);

    foreach ($post->topic->subscriptions as $subscription) {
      if ($user->id !== $subscription->user_id) {
        Mail::send('emails.topic_reply', compact('post'), function ($message) use ($subscription) {
          $message->to($subscription->user->email);
          $message->subject('A topic you have subscribed to has received a reply');
        });
      }
    }

    $user->subscribeTo($topic);

    return redirect(Pagination::getPostUrl($post));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  Post  $post
   * @return \Illuminate\Http\Response
   */
  public function edit(Post $post)
  {
    $this->authorize('update', $post);

    return view('posts.edit', compact('post'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  PostRequest  $request
   * @param  Post  $post
   * @return \Illuminate\Http\Response
   */
  public function update(PostRequest $request, Post $post)
  {
    $post->update($request->only('content'));

    return redirect(Pagination::getPostUrl($post));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Post  $post
   * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    $this->authorize($post);

    $post->delete();

    return redirect()->route('topics.show', ['topic' => $post->topic]);
  }

  /**
   * Restores the specified resource to storage.
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function restore($id)
  {
    $post = Post::withTrashed()->findOrFail($id);
    $this->authorize($post);

    $post->restore();

    return redirect(Pagination::getPostUrl($post));
  }
}
