<?php

use Illuminate\Database\Seeder;

use App\Permission;

class PermissionsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $names = [
      'viewAdminPanel', 'create', 'update', 'delete',
      'viewAdminPanel.user', 'update.user',
      'viewAdminPanel.role', 'create.role', 'update.role', 'delete.role',
      'update.permissions',
      'create.category', 'update.category', 'delete.category',
      'viewAdminPanel.board', 'create.board', 'update.board', 'delete.board',
      'update.topic', 'delete.topic', 'lock.topic', 'pin.topic',
      'update.post', 'delete.post', 'restore.post',
    ];

    foreach ($names as $name) {
      Permission::create(compact('name'));
    }
  }
}
