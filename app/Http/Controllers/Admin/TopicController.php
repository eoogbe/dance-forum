<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Topic;
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
}
