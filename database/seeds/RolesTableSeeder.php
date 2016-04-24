<?php

use Illuminate\Database\Seeder;

use App\Role;

class RolesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $admin = Role::create(['name' => 'admin']);
    $admin->createPermission(['update', 'destroy', 'restore', 'createPost']);

    Role::create(['name' => 'member']);
  }
}
