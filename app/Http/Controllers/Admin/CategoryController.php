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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.categories.index', ['categories' => Category::orderBy('position')->get()]);
  }

  /**
   * Display the specified resource.
   *
   * @param  Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    return view('admin.categories.show', compact('category'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
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
    if ($request->exists('first')) {
      $swapCategory = Category::sortedFirst();
    } else if ($request->exists('up')) {
      $swapCategory = $category->prevCategory();
    } else if ($request->exists('down')) {
      $swapCategory = $category->nextCategory();
    } else if ($request->exists('last')) {
      $swapCategory = Category::sortedLast();
    } else {
      return redirect()->route('admin.categories.index');
    }

    $swapPosition = $swapCategory->position;
    $categoryPosition = $category->position;
    $category->update(['position' => -1]);
    $swapCategory->update(['position' => $categoryPosition]);
    $category->update(['position' => $swapPosition]);

    return redirect()->route('admin.categories.index');
  }
}
