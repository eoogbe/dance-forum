<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
  return [
    'name' => str_slug($faker->userName),
    'email' => $faker->safeEmail,
    'password' => bcrypt('foobarfoobar'),
    'remember_token' => str_random(12),
  ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
  return [
    'name' => str_random(6),
    'slug' => function ($category) {
      return str_slug($category['name']);
    },
    'position' => function () {
      return App\Category::nextPosition();
    }
  ];
});

$factory->define(App\Board::class, function (Faker\Generator $faker) {
  return [
    'name' => str_random(6),
    'slug' => function ($board) {
      return str_slug($board['name']);
    },
    'description' => $faker->sentence,
    'category_id' => function () {
      return factory(App\Category::class)->create()->id;
    },
    'position' => function ($board) {
      return App\Category::find($board['category_id'])->nextBoardPosition();
    }
  ];
});

$factory->define(App\Topic::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->sentence,
    'slug' => function ($topic) {
      return str_slug($topic['name']);
    },
    'board_id' => function () {
      return factory(App\Board::class)->create()->id;
    },
  ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
  return [
    'content' => $faker->paragraph,
    'author_id' => function () {
      return factory(App\User::class)->create()->id;
    },
  ];
});
