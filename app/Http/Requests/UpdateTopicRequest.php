<?php

namespace App\Http\Requests;

use Gate;
use App\Http\Requests\Request;

class UpdateTopicRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return Gate::allows('update', $this->route('topic'));
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $topic = $this->route('topic');
    $topicId = $topic->id;
    $boardId = $topic->board->id;

    return [
      'name' => 'required|max:255|unique:topics,name,'.$topicId.',id,board_id,'.$boardId,
    ];
  }
}
