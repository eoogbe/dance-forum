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
    Role::create(['name' => 'Admin'])->attachPermission([
      'create', 'update', 'delete', 'viewAdminPanel',
      'updateRoles.user', 'updateUsers.role', 'lock.topic', 'pin.topic', 'restore.post',
    ]);
  }
}
