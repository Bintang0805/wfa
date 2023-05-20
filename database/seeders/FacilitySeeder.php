<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
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
        'facility_name' => 'Swimming Pool',
      ],
      [
        'id' => 2,
        'location_id' => 1,
        'facility_name' => 'Gym',
      ],
      [
        'id' => 3,
        'location_id' => 2,
        'facility_name' => 'Playground',
      ],
      [
        'id' => 4,
        'location_id' => 2,
        'facility_name' => 'Tennis Court',
      ],
      [
        'id' => 5,
        'location_id' => 2,
        'facility_name' => 'Cafeteria',
      ],
    ];

    DB::table('facilities')->insert($data);
  }
}
