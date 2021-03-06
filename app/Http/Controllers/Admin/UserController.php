<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\User;
use App\BlockedStatus;
use App\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
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
    $this->authorize('index', User::class);

    return view('admin.users.index', ['users' => User::orderBy('name')->paginate()]);
  }

  /**
   * Display the specified resource.
   *
   * @param  User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    $this->authorize($user);

    return view('admin.users.show', [
      'user' => $user,
      'permissions' => $user->allowedPermissions(),
      'roles' => $user->roles()->orderBy('name')->get(),
    ]);
  }

  /**
   * Sets the blocked status of the specified resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  User  $user
   * @return \Illuminate\Http\Response
   */
  public function ban(Request $request, User $user)
  {
    $this->authorize($user);

    if ($request->blocked_status) {
      $blockedStatus = BlockedStatus::where('name', $request->blocked_status)->firstOrFail();
      $user->blockedStatus()->associate($blockedStatus);
    } else {
      $user->blockedStatus()->dissociate();
    }

    $user->save();

    return redirect()->route('admin.users.show', compact('user'));
  }

  /**
   * Show the form for editing the roles of the specified resource.
   *
   * @param  User  $user
   * @return \Illuminate\Http\Response
   */
  public function editRoles(User $user)
  {
    $this->authorize('updateRoles', $user);

    return view('admin.users.editRoles', [
      'user' => $user,
      'roles' => Role::orderBy('name')->get(),
    ]);
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
    $this->authorize($user);

    $user->roles()->sync($request->role_ids ?: []);

    return redirect()->route('admin.users.show', compact('user'));
  }
}
