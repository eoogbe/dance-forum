<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Role;
use App\User;
use App\Permission;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Controllers\Controller;

class RoleController extends Controller
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
    $this->authorize('index', Role::class);

    return view('admin.roles.index', ['roles' => Role::orderBy('name')->get()]);
  }

  /**
   * Display the specified resource.
   *
   * @param  Role  $role
   * @return \Illuminate\Http\Response
   */
  public function show(Role $role)
  {
    $this->authorize($role);

    return view('admin.roles.show', [
      'role' => $role,
      'permissions' => $role->allowedPermissions(),
      'users' => $role->users()->orderBy('name')->paginate(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->authorize('store', Role::class);

    return view('admin.roles.create', [
      'role' => new Role(),
      'permissions' => Permission::maxDepth(1)->orderBy('name')->get(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  StoreRoleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRoleRequest $request)
  {
    $role = Role::create([
      'name' => $request->name,
    ]);

    if ($request->permission_ids) {
      $permissionIds = array_fill_keys($request->permission_ids, ['has_access' => true]);
      $role->permissions()->attach($permissionIds);
    }

    return redirect()->route('admin.roles.show', compact('role'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  Role  $role
   * @return \Illuminate\Http\Response
   */
  public function edit(Role $role)
  {
    $this->authorize('update', $role);

    return view('admin.roles.edit', [
      'role' => $role,
      'permissions' => Permission::maxDepth(1)->orderBy('name')->get(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  UpdateRoleRequest  $request
   * @param  Role  $role
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRoleRequest $request, Role $role)
  {
    $role->update([
      'name' => $request->name,
    ]);
    $role->setGeneralPermissions($request->permission_ids ?: []);

    return redirect()->route('admin.roles.show', compact('role'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Role  $role
   * @return \Illuminate\Http\Response
   */
  public function destroy(Role $role)
  {
    $this->authorize($role);

    $role->delete();

    return redirect()->route('admin.roles.index');
  }

  /**
   * Show the form for editing the users of the specified resource.
   *
   * @param  Role  $role
   * @return \Illuminate\Http\Response
   */
  public function editUsers(Role $role)
  {
    $this->authorize('updateUsers', $role);

    return view('admin.roles.editUsers', [
      'role' => $role,
      'users' => User::orderBy('name')->get(),
    ]);
  }

  /**
   * Update the users of the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  Role  $role
   * @return \Illuminate\Http\Response
   */
  public function updateUsers(Request $request, Role $role)
  {
    $this->authorize($role);

    $role->users()->sync($request->user_ids ?: []);

    return redirect()->route('admin.roles.show', compact('role'));
  }
}
