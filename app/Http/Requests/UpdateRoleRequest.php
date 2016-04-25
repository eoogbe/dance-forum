<?php

namespace App\Http\Requests;

use Gate;
use App\Http\Requests\Request;

class UpdateRoleRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return Gate::allows('update', $this->route('role'));
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $roleId = $this->route('role')->id;

    return [
      'name' => 'required|max:255|unique:roles,name,'.$roleId.',id',
    ];
  }
}
