<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Topic;
use App\Role;
use App\Http\Requests\UpdateTopicRequest;
use App\Http\Controllers\Controller;

class TopicController extends Controller
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
   * Show the form for editing the specified resource.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function edit(Topic $topic)
  {
    $this->authorize('update', $topic);

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
    $this->authorize($topic);

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
    $this->authorize($topic);

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
    $this->authorize('pin', $topic);

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
    $this->authorize($topic);

    $topic->update(['locked_at' => Carbon::now()]);

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
    $this->authorize('lock', $topic);

    $topic->update(['locked_at' => null]);

    return redirect()->route('boards.show', ['board' => $topic->board]);
  }

  /**
   * Hides the specified resource.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function hide(Topic $topic)
  {
    $this->authorize($topic);

    $topic->update(['hidden_at' => Carbon::now()]);

    return redirect()->route('boards.show', ['board' => $topic->board]);
  }

  /**
   * Unmarks the specified resource as hidden.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function unhide(Topic $topic)
  {
    $this->authorize('hide', $topic);

    $topic->update(['hidden_at' => null]);

    return redirect()->route('boards.show', ['board' => $topic->board]);
  }

  /**
   * Show the form for editing the permissions of the specified resource.
   *
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function editPermissions(Topic $topic)
  {
    $this->authorize('updatePermissions', $topic);

    return view('admin.topics.editPermissions', [
      'topic' => $topic,
      'roles' => Role::orderBy('name')->get(),
    ]);
  }

  /**
   * Update the permissions of the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function updatePermissions(Request $request, Topic $topic)
  {
    $this->authorize($topic);

    $updateRoles = $request->update_roles ?: [];
    $destroyRoles = $request->destroy_roles ?: [];

    $updatePermissionName = "update.topic.{$topic->id}";
    $destroyPermissionName = "delete.topic.{$topic->id}";

    foreach (Role::all() as $role) {
      if (in_array($role->id, $updateRoles)) {
        $role->allow($updatePermissionName);
      } else {
        $role->deny($updatePermissionName);
      }

      if (in_array($role->id, $destroyRoles)) {
        $role->allow($destroyPermissionName);
      } else {
        $role->deny($destroyPermissionName);
      }
    }

    return redirect()->route('topics.show', compact('topic'));
  }
}
