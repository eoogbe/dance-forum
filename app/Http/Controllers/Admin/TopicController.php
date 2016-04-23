<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Topic;
use App\Role;
use App\Permission;
use App\Http\Requests\UpdateTopicRequest;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
  /**
   * Show the form for editing the specified resource.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function edit(Topic $topic)
  {
    return view('admin.topics.edit', compact('topic'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  UpdateTopicRequest  $request
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateTopicRequest $request, Topic $topic)
  {
    $topic->update([
      'name' => $request->name
    ]);

    return redirect()->route('topics.show', compact('topic'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function destroy(Topic $topic)
  {
    $topic->delete();

    return redirect()->route('boards.show', ['board' => $topic->board]);
  }

  /**
   * Pins the specified resource.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function pin(Topic $topic)
  {
    $topic->update(['pinned_at' => Carbon::now()]);

    return redirect()->route('boards.show', ['board' => $topic->board]);
  }

  /**
   * Unpins the specified resource.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function unpin(Topic $topic)
  {
    $topic->update(['pinned_at' => null]);

    return redirect()->route('boards.show', ['board' => $topic->board]);
  }

  /**
   * Locks the specified resource.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function lock(Topic $topic)
  {
    $permission = Permission::where('name', "createPost.topic.{$topic->id}")->first();
    Role::where('name', 'member')->first()->permissions()->detach($permission);

    return redirect()->route('boards.show', ['board' => $topic->board]);
  }

  /**
   * Unlocks the specified resource.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function unlock(Topic $topic)
  {
    $permission = Permission::where('name', "createPost.topic.{$topic->id}")->first();
    Role::where('name', 'member')->first()->permissions()->attach($permission);

    return redirect()->route('boards.show', ['board' => $topic->board]);
  }
}
