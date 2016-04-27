<?php

namespace App\Helpers;

class Highlighter
{
  public function mark($text, $phrase)
  {
    if (empty($phrase)) {
      return $text;
    }

    $pattern = preg_quote(e(strip_tags($phrase)));

    return preg_replace("/($pattern)/i", '<mark>$1</mark>', e(strip_tags($text)));
  }
}
