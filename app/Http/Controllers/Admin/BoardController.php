<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Board;
use App\Role;
use App\Category;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Http\Controllers\Controller;

class BoardController extends Controller
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->authorize('index', Board::class);

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
    $this->authorize($board);

    return view('admin.boards.show', compact('board'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->authorize('store', Board::class);

    return view('admin.boards.create', [
      'board' => new Board(),
      'categories' => Category::orderBy('position')->get(),
    ]);
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
    $this->authorize('update', $board);

    return view('admin.boards.edit', [
      'board' => $board,
      'categories' => Category::orderBy('position')->get(),
    ]);
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
    $this->authorize($board);

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
    $this->authorize('update', $board);

    $swapBoard = Board::findOrFail($request->swap_id);

    $swapPosition = $swapBoard->position;
    $boardPosition = $board->position;

    $board->update(['position' => -1]);
    $swapBoard->update(['position' => $boardPosition]);
    $board->update(['position' => $swapPosition]);

    return back();
  }

  /**
   * Show the form for editing the permissions of the specified resource.
   *
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function editPermissions(Board $board)
  {
    $this->authorize('updatePermissions', $board);

    return view('admin.boards.editPermissions', [
      'board' => $board,
      'roles' => Role::orderBy('name')->get(),
    ]);
  }

  /**
   * Update the permissions of the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function updatePermissions(Request $request, Board $board)
  {
    $this->authorize($board);

    $updateRoles = $request->update_roles ?: [];
    $destroyRoles = $request->destroy_roles ?: [];

    $updatePermissionName = "update.board.{$board->id}";
    $destroyPermissionName = "delete.board.{$board->id}";

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

    return redirect()->route('admin.boards.show', compact('board'));
  }
}
