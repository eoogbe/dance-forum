<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Category;
use App\Board;
use App\Topic;
use App\Post;
use App\Http\Requests;

class ForumController extends Controller
{
  /**
   * Display search results for the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    $term = $request->term;

    if (!$term) {
      return redirect()->back();
    }

    $pattern = "%$term%";

    return view('forum.search', [
      'term' => $term,
      'users' => User::where('name', 'like', $pattern),
      'categories' => Category::where('name', 'like', $pattern),
      'boards' => Board::where('name', 'like', $pattern),
      'topics' => Topic::where('name', 'like', $pattern),
      'posts' => Post::where('content', 'like', $pattern),
    ]);
  }
}
