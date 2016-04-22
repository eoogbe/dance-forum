<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
  use DatabaseTransactions;

  public function testNewUserRegistration()
  {
    $user = factory(App\User::class)->make();

    $this->visit('/register')
      ->type($user->name, 'username')
      ->type($user->email, 'email')
      ->type($user->password, 'password')
      ->type($user->password, 'password_confirmation')
      ->press('Register')
      ->seePageIs('/');
  }

  public function testNewUserRegistrationPasswordTooShort()
  {
    $user = factory(App\User::class)->make();
    $password = str_random(10);

    $this->visit('/register')
      ->type($user->name, 'username')
      ->type($user->email, 'email')
      ->type($password, 'password')
      ->type($password, 'password_confirmation')
      ->press('Register')
      ->see('The password must be at least 12 characters');
  }

  public function testNewUserRegistrationUsernameWithSpaces()
  {
    $user = factory(App\User::class)->make();

    $this->visit('/register')
      ->type('Channing Tatum', 'username')
      ->type($user->email, 'email')
      ->type($user->password, 'password')
      ->type($user->password, 'password_confirmation')
      ->press('Register')
      ->see('The username may only contain letters, numbers, and dashes.');
  }
}
