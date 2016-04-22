<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreBoardRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return $this->user()->hasRole('admin');
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required|max:255|unique:boards,name,NULL,id,category_id,'.$this->category_id,
      'description' => 'required',
      'category_id' => 'required',
    ];
  }
}
