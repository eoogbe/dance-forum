<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Category;
use App\Board;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Http\Controllers\Controller;

class BoardController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.boards.index', ['categories' => Category::orderBy('position')->get()]);
  }

  /**
   * Display the specified resource.
   *
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function show(Board $board)
  {
    return view('admin.boards.show', compact('board'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.boards.create', ['board' => new Board(), 'categories' => Category::all()]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  StoreBoardRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreBoardRequest $request)
  {
    $category = Category::findOrFail($request->category_id);
    $board = $category->boards()->create([
      'name' => $request->name,
      'description' => $request->description,
      'position' => $category->nextBoardPosition(),
    ]);

    return redirect()->route('admin.boards.show', compact('board'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function edit(Board $board)
  {
    return view('admin.boards.edit', ['board' => $board, 'categories' => Category::all()]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  UpdateBoardRequest  $request
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateBoardRequest $request, Board $board)
  {
    if ($request->category_id !== $board->category_id) {
      $category = Category::findOrFail($request->category_id);
      $position = $category->nextBoardPosition();
      $category->boards()->save($board);
    } else {
      $position = $board->position;
    }

    $board->update([
      'name' => $request->name,
      'description' => $request->description,
      'position' => $position,
    ]);

    return redirect()->route('admin.boards.show', compact('board'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function destroy(Board $board)
  {
    $board->delete();

    return redirect()->route('admin.boards.index');
  }

  /**
   * Update the position of the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function position(Request $request, Board $board)
  {
    $swapBoard = Board::findOrFail($request->swap_id);

    $swapPosition = $swapBoard->position;
    $boardPosition = $board->position;
    
    $board->update(['position' => -1]);
    $swapBoard->update(['position' => $boardPosition]);
    $board->update(['position' => $swapPosition]);

    return back();
  }
}
