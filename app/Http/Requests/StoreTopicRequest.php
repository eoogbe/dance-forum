<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreTopicRequest extends Request
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
    $boardId = $this->route('board')->id;

    return [
      'name' => 'required|max:255|unique:topics,name,NULL,id,board_id,'.$boardId,
      'post_content' => 'required'
    ];
  }
}
