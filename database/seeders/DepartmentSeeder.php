<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
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
        'id' => 1,
        'location_id' => 1,
        'facility_id' => 1,
        'department' => 'Sales',
      ],
      [
        'id' => 2,
        'location_id' => 1,
        'facility_id' => 1,
        'department' => 'Marketing',
      ],
      [
        'id' => 3,
        'location_id' => 2,
        'facility_id' => 3,
        'department' => 'HR',
      ],
      [
        'id' => 4,
        'location_id' => 2,
        'facility_id' => 4,
        'department' => 'Finance',
      ],
      [
        'id' => 5,
        'location_id' => 2,
        'facility_id' => 5,
        'department' => 'IT',
      ],
    ];

    DB::table('departments')->insert($data);
  }
}
