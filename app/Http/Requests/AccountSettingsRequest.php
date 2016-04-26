<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class AccountSettingsRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return Auth::check();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'current_password' => 'required|password',
      'username' => 'max:255|alpha_dash',
      'email' => 'email|max:255|unique:users,email,'.Auth::id().',id',
      'password' => 'min:12|confirmed',
    ];
  }
}
