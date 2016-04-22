<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::singularResourceParameters();

Route::get('', 'CategoryController@index');

Route::auth();

Route::get('boards/{board}', ['as' => 'boards.show', 'uses' => 'BoardController@show']);
Route::get('topics/{topic}', ['as' => 'topics.show', 'uses' => 'TopicController@show']);
Route::post('posts/{id}/restore', ['as' => 'posts.restore', 'uses' => 'PostController@restore']);

Route::resource('categories', 'CategoryController', ['only' => ['index', 'show']]);
Route::resource('boards.topics', 'TopicController', ['only' => ['create', 'store']]);
Route::resource('topics.posts', 'PostController', ['only' => ['create', 'store']]);
Route::resource('posts', 'PostController', ['only' => ['edit', 'update', 'destroy']]);

Route::group([
  'middleware' => ['auth', 'role:admin'],
  'namespace' => 'Admin',
  'prefix' => 'admin',
], function() {
  Route::get('', 'BoardController@index');
  Route::put('boards/{board}/position', [
    'as' => 'admin.boards.position',
    'uses' => 'BoardController@position'
  ]);
  Route::resource('categories', 'CategoryController');
  Route::resource('boards', 'BoardController');
  Route::resource('topics', 'TopicController', ['only' => ['edit', 'update', 'destroy']]);
});
