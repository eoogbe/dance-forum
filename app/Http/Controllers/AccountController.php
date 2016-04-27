<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AccountSettingsRequest;

class AccountController extends Controller
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
   * Show the form for editing the profile of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function editProfile()
  {
    return view('account.editProfile');
  }

  /**
   * Update the profile of the resource in storage.
   *
   * @param  ProfileRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function updateProfile(ProfileRequest $request)
  {
    $user = $request->user();

    $user->update($request->only('pronouns', 'description'));

    return redirect()->route('users.show', compact('user'));
  }

  /**
   * Show the form for editing the settings of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function editSettings()
  {
    return view('account.editSettings');
  }

  /**
   * Update the settings of the resource in storage.
   *
   * @param  AccountSettingsRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function updateSettings(AccountSettingsRequest $request)
  {
    $user = $request->user();

    $user->update(array_filter([
      'name' => $request->username,
      'email' => $request->email,
      'password' => $request->password ? bcrypt($request->password) : null,
    ]));

    return redirect()->route('users.show', compact('user'));
  }

  /**
   * Remove the resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $request->user()->delete();

    return redirect('/');
  }
}
