<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
  use _generated\FunctionalTesterActions;

  public function createTopic($topicAttrs = [], $postAttrs = [])
  {
    $I = $this;

    $topic = $I->createModel('App\Topic', $topicAttrs);
    $topic->posts()->save($I->makeModel('App\Post', $postAttrs));

    return $topic;
  }

  public function grabAdmin()
  {
    $I = $this;
    
    return $I->grabRole()->users()->first();
  }
}
