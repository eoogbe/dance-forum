<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.users.index', ['users' => User::paginate()]);
  }

  /**
   * Display the specified resource.
   *
   * @param  User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    return view('admin.users.show', compact('user'));
  }

  /**
   * Show the form for editing the roles of the specified resource.
   *
   * @param  User  $user
   * @return \Illuminate\Http\Response
   */
  public function editRoles(User $user)
  {
    return view('admin.users.editRoles', ['user' => $user, 'roles' => Role::all()]);
  }

  /**
   * Update the roles of the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  User  $user
   * @return \Illuminate\Http\Response
   */
  public function updateRoles(Request $request, User $user)
  {
    $user->roles()->sync($request->role_ids);

    return redirect()->route('admin.users.show', compact('user'));
  }
}
