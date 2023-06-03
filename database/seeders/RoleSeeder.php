<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      [
        'id' => '1',
        'role_name' => 'Admin',
      ],
      [
        'id' => '2',
        'role_name' => 'User',
      ],
    ];

    DB::table('roles')->insert($data);
  }
}
