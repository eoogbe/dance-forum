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

Route::get('profile/edit', [
  'as' => 'account.editProfile',
  'uses' => 'AccountController@editProfile',
]);
Route::put('profile', [
  'as' => 'account.updateProfile',
  'uses' => 'AccountController@updateProfile',
]);
Route::get('account/edit', [
  'as' => 'account.editSettings',
  'uses' => 'AccountController@editSettings',
]);
Route::put('account', [
  'as' => 'account.updateSettings',
  'uses' => 'AccountController@updateSettings',
]);
Route::post('posts/{id}/restore', ['as' => 'posts.restore', 'uses' => 'PostController@restore']);

Route::resource('users', 'UserController', ['only' => 'show']);
Route::resource('categories', 'CategoryController', ['only' => ['index', 'show']]);
Route::resource('boards', 'BoardController', ['only' => 'show']);
Route::resource('boards.topics', 'TopicController', ['only' => ['create', 'store']]);
Route::resource('topics', 'TopicController', ['only' => 'show']);
Route::resource('topics.posts', 'PostController', ['only' => ['create', 'store']]);
Route::resource('posts', 'PostController', ['only' => ['edit', 'update', 'destroy']]);

Route::group([
  'namespace' => 'Admin',
  'prefix' => 'admin',
], function() {
  Route::get('', 'BoardController@index');
  Route::put('categories/{category}/position', [
    'as' => 'admin.categories.position',
    'uses' => 'CategoryController@position'
  ]);
  Route::get('categories/{category}/permissions/edit', [
    'as' => 'admin.categories.editPermissions',
    'uses' => 'CategoryController@editPermissions'
  ]);
  Route::put('categories/{category}/permissions', [
    'as' => 'admin.categories.updatePermissions',
    'uses' => 'CategoryController@updatePermissions'
  ]);
  Route::put('boards/{board}/position', [
    'as' => 'admin.boards.position',
    'uses' => 'BoardController@position'
  ]);
  Route::get('boards/{board}/permissions/edit', [
    'as' => 'admin.boards.editPermissions',
    'uses' => 'BoardController@editPermissions'
  ]);
  Route::put('boards/{board}/permissions', [
    'as' => 'admin.boards.updatePermissions',
    'uses' => 'BoardController@updatePermissions'
  ]);
  Route::post('topics/{topic}/pin', [
    'as' => 'admin.topics.pin',
    'uses' => 'TopicController@pin'
  ]);
  Route::post('topics/{topic}/unpin', [
    'as' => 'admin.topics.unpin',
    'uses' => 'TopicController@unpin'
  ]);
  Route::post('topics/{topic}/lock', [
    'as' => 'admin.topics.lock',
    'uses' => 'TopicController@lock'
  ]);
  Route::post('topics/{topic}/unlock', [
    'as' => 'admin.topics.unlock',
    'uses' => 'TopicController@unlock'
  ]);
  Route::post('topics/{topic}/hide', [
    'as' => 'admin.topics.hide',
    'uses' => 'TopicController@hide'
  ]);
  Route::post('topics/{topic}/show', [
    'as' => 'admin.topics.unhide',
    'uses' => 'TopicController@unhide'
  ]);
  Route::get('topics/{topic}/permissions/edit', [
    'as' => 'admin.topics.editPermissions',
    'uses' => 'TopicController@editPermissions'
  ]);
  Route::put('topics/{topic}/permissions', [
    'as' => 'admin.topics.updatePermissions',
    'uses' => 'TopicController@updatePermissions'
  ]);
  Route::get('users/{user}/roles/edit', [
    'as' => 'admin.users.editRoles',
    'uses' => 'UserController@editRoles'
  ]);
  Route::put('users/{user}/roles', [
    'as' => 'admin.users.updateRoles',
    'uses' => 'UserController@updateRoles'
  ]);
  Route::get('roles/{role}/users/edit', [
    'as' => 'admin.roles.editUsers',
    'uses' => 'RoleController@editUsers'
  ]);
  Route::put('roles/{role}/users', [
    'as' => 'admin.roles.updateUsers',
    'uses' => 'RoleController@updateUsers'
  ]);
  Route::resource('categories', 'CategoryController');
  Route::resource('boards', 'BoardController');
  Route::resource('roles', 'RoleController');
  Route::resource('topics', 'TopicController', ['only' => ['edit', 'update', 'destroy']]);
  Route::resource('users', 'UserController', ['only' => ['index', 'show']]);
});
