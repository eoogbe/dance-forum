<?php

namespace App\Http\Requests;

use Gate;
use App\Category;
use App\Http\Requests\Request;

class StoreCategoryRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return Gate::allows('store', Category::class);
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required|max:255|unique:categories',
    ];
  }
}
