<?php


class AccountControllerCest
{
  public function updateProfile(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('update my profile');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('account.editProfile');

    $updatedProfile = $I->makeModel('App\User');
    $I->fillField('Appropriate Gender Pronouns', $updatedProfile->pronouns);
    $I->fillField('description', $updatedProfile->description);

    $I->click('Update Profile');
    $I->see($updatedProfile->pronouns);
    $I->see($updatedProfile->description);
  }

  public function preventUpdateProfileWithoutAuthenticated(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('be prevented from updating a profile');

    $I->amOnRoute('account.editProfile');
    $I->seeCurrentUrlEquals('/login');
  }

  public function updateSettings(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('update my account settings');

    $password = str_random(12);
    $user = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $I->amLoggedAs($user);

    $I->amOnRoute('account.editSettings');

    $updatedSettings = $I->makeModel('App\User');
    $I->fillField('Current Password', $password);
    $I->fillField('Username', $updatedSettings->name);

    $I->click('Update Settings');
    $I->see($updatedSettings->name);
  }

  public function preventUpdateSettingsWithIncorrectPassword(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating my account settings with an incorrect password');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('account.editSettings');

    $updatedSettings = $I->makeModel('App\User');
    $I->fillField('Current Password', str_random(12));
    $I->fillField('Username', $updatedSettings->name);

    $I->click('Update Settings');
    $I->seeFormErrorMessage('current_password', 'The current password is incorrect');
  }

  public function preventUpdateSettingsWithoutAuthenticated(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('be prevented from updating account settings');

    $I->amOnRoute('account.editSettings');
    $I->seeCurrentUrlEquals('/login');
  }

  public function destroyAccount(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('cancel my account');

    $topic = $I->createTopic();
    $user = $topic->author();
    $I->amLoggedAs($user);

    $I->amOnRoute('account.editSettings');
    $I->click('Cancel Your Account');

    $I->seeCurrentUrlEquals('/');
    $I->dontSee($user->name);
    $I->dontSeeAuthentication();
    $I->amOnRoute('topics.show', compact('topic'));
    $I->dontSee($user->name);
    $I->see('[deleted]');
    $I->see($topic->firstPost()->content);
  }
}
