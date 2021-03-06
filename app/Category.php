<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use Sluggable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'position'];

  /**
   * Get the first category when sorted by position.
   */
  public static function sortedFirst()
  {
    return static::orderBy('position')->first();
  }

  /**
   * Get the first category when sorted by position.
   */
  public static function sortedLast()
  {
    return static::orderBy('position', 'desc')->first();
  }

  /**
   * Get the next position of a category.
   */
  public static function nextPosition()
  {
    $category = static::sortedLast();

    return $category ? $category->position + 1 : 0;
  }

  /**
   * Get all the boards for the category.
   */
  public function boards()
  {
    return $this->hasMany(Board::class);
  }

  /**
   * Get all the boards for the category sorted by position.
   */
  public function sortedBoards()
  {
    return $this->boards()->orderBy('position');
  }

  /**
  * Get the first board for the category.
  */
  public function firstBoard()
  {
    return $this->sortedBoards()->first();
  }

  /**
  * Get the last board for the category.
  */
  public function lastBoard()
  {
    return $this->reverseSortedBoards()->first();
  }

  /**
   * Get the board for the category whose position come right before the given position.
   */
  public function boardBefore($position)
  {
    return $this->reverseSortedBoards()->where('position', '<', $position)->first();
  }

  /**
   * Get the board for the category whose position come right after the given position.
   */
  public function boardAfter($position)
  {
    return $this->sortedBoards()->where('position', '>', $position)->first();
  }

  /**
   * Get the next position of a board for the category.
   */
  public function nextBoardPosition()
  {
    $board = $this->lastBoard();

    return $board ? $board->position + 1 : 0;
  }

  /**
   * Get all the boards for the category sorted in reverse by position.
   */
  private function reverseSortedBoards()
  {
    return $this->boards()->orderBy('position', 'desc');
  }

  /**
   * Checks if the category contains the given board.
   */
  public function hasBoard($board)
  {
    return $this->id == $board->category_id;
  }

  /**
   * Get the previous category.
   */
  public function prevCategory()
  {
    return static::orderBy('position', 'desc')->where('position', '<', $this->position)->first();
  }

  /**
   * Get the next category.
   */
  public function nextCategory()
  {
    return static::orderBy('position')->where('position', '>', $this->position)->first();
  }

  /**
   * Check if the category is the first one.
   */
  public function isFirst()
  {
    return !static::where('position', '<', $this->position)->exists();
  }

  /**
   * Check if the category is the last one.
   */
  public function isLast()
  {
    return !static::where('position', '>', $this->position)->exists();
  }
}
