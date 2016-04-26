<?php
namespace Page;

class Login
{
  public static $URL = '/login';

  /**
  * @var AcceptanceTester
  */
  protected $tester;

  public function __construct(\AcceptanceTester $I)
  {
    $this->tester = $I;
  }

  public function login($email, $password)
  {
    $I = $this->tester;

    $I->amOnPage(static::$URL);
    $I->fillField('Email', $email);
    $I->fillField('Password', $password);
    $I->click('Login');
  }
}
