<?php

use Illuminate\Database\Seeder;

use App\User;
use App\BlockedStatus;
use App\Role;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    BlockedStatus::create(['name' => 'banned']);
    BlockedStatus::create(['name' => 'shadow banned']);

    $user = User::create([
      'name' => 'kortega',
      'email' => 'admin@example.com',
      'password' => bcrypt(env('ADMIN_PASSWORD')),
    ]);

    $user->roles()->attach(Role::where('name', 'Admin')->first());
  }
}
