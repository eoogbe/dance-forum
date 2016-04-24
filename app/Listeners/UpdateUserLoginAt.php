<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserLoginAt
{
  /**
   * Handle the event.
   *
   * @param  User $user
   * @return void
   */
  public function handle($user)
  {
    $user->update(['login_at' => Carbon::now()]);
  }
}
