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
      [
        'id' => '3',
        'role_name' => 'Developer',
      ],
      [
        'id' => '4',
        'role_name' => 'Tester',
      ],
      [
        'id' => '5',
        'role_name' => 'Project Manager',
      ],
      [
        'id' => '6',
        'role_name' => 'Database Administrator',
      ],
      [
        'id' => '7',
        'role_name' => 'Network Engineer',
      ],
      [
        'id' => '8',
        'role_name' => 'System Analyst',
      ],
      [
        'id' => '9',
        'role_name' => 'UI/UX Designer',
      ],
      [
        'id' => '10',
        'role_name' => 'IT Support',
      ],
    ];

    DB::table('roles')->insert($data);
  }
}
