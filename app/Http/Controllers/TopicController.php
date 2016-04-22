<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Board;
use App\Topic;
use App\Http\Requests\StoreTopicRequest;

class TopicController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth', ['except' => ['show']]);
  }

  /**
  * Display the specified resource.
  *
  * @param  Topic  $topic
  * @return \Illuminate\Http\Response
  */
  public function show(Topic $topic)
  {
    return view('topics.show', compact('topic'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @param Board $board
   * @return \Illuminate\Http\Response
   */
  public function create(Board $board)
  {
    return view('topics.create', compact('board'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  StoreTopicRequest  $request
   * @param Board $board
   * @return \Illuminate\Http\Response
   */
  public function store(StoreTopicRequest $request, Board $board)
  {
    $topic = $board->topics()->create([
      'name' => $request->name,
    ]);

    $request->user()->posts()->create([
      'topic_id' => $topic->id,
      'content' => $request->post_content,
    ]);

    return redirect()->route('topics.show', compact('topic'));
  }
}
