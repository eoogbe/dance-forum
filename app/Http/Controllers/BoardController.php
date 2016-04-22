<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Board;
use App\Http\Requests;

class BoardController extends Controller
{
  /**
   * Display the specified resource.
   *
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function show(Board $board)
  {
    return view('boards.show', compact('board'));
  }
}
