<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategoriesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $category = Category::create(['name' => 'Social Dance']);
    $category->boards()->createMany([
      [
        'name' => 'Waltz',
        'description' => 'Turning dances that move around the room',
        'position' => 0,
      ],
      [
        'name' => 'Swing',
        'description' => 'Dances to music that is swung',
        'position' => 1,
      ],
    ]);
  }
}
