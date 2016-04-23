<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use App\Board;
use App\Http\Requests;

class BoardController extends Controller
{
  /**
   * Display the specified resource.
   *
   * @param \Illuminate\Http\Request $request
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, Board $board)
  {
    if (Auth::check()) {
      $board->views()->firstOrCreate(['user_id' => Auth::id()])->increment('count');
    }

    $perPage = 15;
    $page = Paginator::resolveCurrentPage();
    $items = $board->sortedTopics()->skip(($page - 1) * $perPage)->take($perPage)->get();

    $paginatedTopics = new LengthAwarePaginator($items, $board->topicCount(), $perPage, $page, [
      'path'  => $request->url(),
      'query' => $request->query(),
    ]);

    return view('boards.show', ['board' => $board, 'topics' => $paginatedTopics]);
  }
}
