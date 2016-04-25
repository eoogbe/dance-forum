<?php

namespace App\Http\Requests;

use Gate;
use App\Http\Requests\Request;

class UpdateCategoryRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return Gate::allows('update', $this->route('category'));
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $categoryId = $this->route('category')->id;

    return [
      'name' => 'required|max:255|unique:categories,name,'.$categoryId.',id',
    ];
  }
}
