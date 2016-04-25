<?php

namespace Auth;

use \FunctionalTester;

class AuthControllerCest
{
  public function login(FunctionalTester $I)
  {
    $password = str_random(12);
    $user = $I->createModel('App\User', ['password' => bcrypt($password)]);

    $I->amOnPage('/login');
    $I->fillField('Email', $user->email);
    $I->fillField('Password', $password);
    $I->click('Login');
    $I->seeAuthentication();
  }

  public function register(FunctionalTester $I)
  {
    $password = str_random(12);
    $user = $I->makeModel('App\User');

    $I->amOnPage('/register');
    $I->fillField('Username', $user->name);
    $I->fillField('Email', $user->email);
    $I->fillField('Password', $password);
    $I->fillField('Confirm Password', $password);
    $I->click('Register');
    $I->seeRecord('users', ['name' => $user->name, 'email' => $user->email]);
  }

  public function preventRegisterWithPasswordTooShort(FunctionalTester $I)
  {
    $password = str_random(10);
    $user = $I->makeModel('App\User');

    $I->amOnPage('/register');
    $I->fillField('Username', $user->name);
    $I->fillField('Email', $user->email);
    $I->fillField('Password', $password);
    $I->fillField('Confirm Password', $password);
    $I->click('Register');
    $I->seeFormErrorMessage('password', 'The password must be at least 12 characters');
  }

  public function preventRegisterWithUsernameContainingSpaces(FunctionalTester $I)
  {
    $password = str_random(12);
    $user = $I->makeModel('App\User');

    $I->amOnPage('/register');
    $I->fillField('Username', 'Channing Tatum');
    $I->fillField('Email', $user->email);
    $I->fillField('Password', $password);
    $I->fillField('Confirm Password', $password);
    $I->click('Register');
    $I->seeFormErrorMessage('username',
      'The username may only contain letters, numbers, and dashes');
  }
}
