<?php

namespace App\Helpers;

class Pagination
{
  public function getPostUrl($post)
  {
    $posts = $post->topic->paginatedPosts();
    $posts->setPath(route('topics.show', ['topic' => $post->topic]));
    $posts->fragment("post-{$post->id}");
    $page = ceil($post->offset() / $posts->perPage());

    return $posts->url($page);
  }
}
