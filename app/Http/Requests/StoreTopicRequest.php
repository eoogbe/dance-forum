<?php

namespace App\Http\Requests;

use Gate;
use App\Topic;
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
    return Gate::allows('store', Topic::class);
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
