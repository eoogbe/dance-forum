<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
  use DatabaseTransactions;

  public function testLogin()
  {
    $password = 'foobarfoobar';
    $user = factory(App\User::class)->create(['password' => bcrypt($password)]);

    $this->visit('/login')
      ->type($user->email, 'email')
      ->type($password, 'password')
      ->press('Login')
      ->seePageIs('/');
  }

  public function testProtectedRouteWithoutAuthenticatedUser()
  {
    $board = App\Board::orderBy('position')->first();

    $this->visit("/boards/{$board->slug}/topics/create")
      ->seePageIs('/login');
  }

  public function testProtectedRouteWithAuthenticatedUser()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();
    $protectedUrl = "/boards/{$board->slug}/topics/create";

    $this->actingAs($user)
      ->visit($protectedUrl)
      ->seePageIs($protectedUrl);
  }
}
