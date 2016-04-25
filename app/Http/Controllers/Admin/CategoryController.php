<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
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
    $this->authorize('index', Category::class);

    return view('admin.categories.index', [
      'categories' => Category::orderBy('position')->get(),
      'firstCategory' => Category::sortedFirst(),
      'lastCategory' => Category::sortedLast(),
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    $this->authorize($category);

    return view('admin.categories.show', compact('category'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->authorize('store', Category::class);

    return view('admin.categories.create', ['category' => new Category()]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  StoreCategoryRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreCategoryRequest $request)
  {
    $category = Category::create([
      'name' => $request->name,
      'position' => Category::nextPosition(),
    ]);

    return redirect()->route('admin.categories.show', compact('category'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  Category  $category
   * @return \Illuminate\Http\Response
   */
  public function edit(Category $category)
  {
    $this->authorize('update', $category);

    return view('admin.categories.edit', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  UpdateCategoryRequest  $request
   * @param  Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateCategoryRequest $request, Category $category)
  {
    $category->update([
      'name' => $request->name,
    ]);

    return redirect()->route('admin.categories.show', compact('category'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    $this->authorize($category);

    $category->delete();

    return redirect()->route('admin.categories.index');
  }

  /**
   * Update the position of the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  Category  $category
   * @return \Illuminate\Http\Response
   */
  public function position(Request $request, Category $category)
  {
    $this->authorize('update', $category);

    $swapCategory = Category::findOrFail($request->swap_id);

    $swapPosition = $swapCategory->position;
    $categoryPosition = $category->position;

    $category->update(['position' => -1]);
    $swapCategory->update(['position' => $categoryPosition]);
    $category->update(['position' => $swapPosition]);

    return redirect()->route('admin.categories.index');
  }
}
