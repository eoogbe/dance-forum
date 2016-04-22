<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Http\Requests;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('categories.index', ['categories' => Category::orderBy('position')->get()]);
  }

  /**
   * Display the specified resource.
   *
   * @param  Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    return view('categories.show', compact('category'));
  }
}
