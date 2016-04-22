<?php

use Illuminate\Database\Seeder;

use App\User;
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
    $user = User::create([
      'name' => 'kortega',
      'email' => 'admin@example.com',
      'password' => bcrypt(env('ADMIN_PASSWORD')),
    ]);

    $user->roles()->attach(Role::where('name', 'admin')->first());
  }
}
