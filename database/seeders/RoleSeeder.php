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
        'name' => 'Super Admin',
        'guard_name' => "web"
      ],
      [
        'id' => '2',
        'name' => 'Admin',
        'guard_name' => "web"
      ],
      [
        'id' => '3',
        'name' => 'User',
        'guard_name' => "web"
      ],
      [
        'id' => '4',
        'name' => 'Developer',
        'guard_name' => "web"
      ],
      [
        'id' => '5',
        'name' => 'Tester',
        'guard_name' => "web"
      ],
      [
        'id' => '6',
        'name' => 'Project Manager',
        'guard_name' => "web"
      ],
      [
        'id' => '7',
        'name' => 'Network Engineer',
        'guard_name' => "web"
      ],
      [
        'id' => '8',
        'name' => 'System Analyst',
        'guard_name' => "web"
      ],
      [
        'id' => '9',
        'name' => 'UI/UX Designer',
        'guard_name' => "web"
      ],
      [
        'id' => '10',
        'name' => 'IT Support',
        'guard_name' => "web"
      ],
    ];

    DB::table('roles')->insert($data);
  }
}
