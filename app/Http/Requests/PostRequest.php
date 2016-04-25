<?php

namespace App\Http\Requests;

use Gate;
use App\Post;
use App\Http\Requests\Request;

class PostRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    $topic = $this->route('topic');

    return $topic
      ? Gate::allows('addPost', $topic)
      : Gate::allows('update', $this->route('post'));
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'content' => 'required',
      'parent_id' => 'exists:posts,id'
    ];
  }
}
