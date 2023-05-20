<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypeSeeder extends Seeder
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
        'equipment_type' => 'Computer',
      ],
      [
        'id' => 2,
        'equipment_type' => 'Printer',
      ],
      [
        'id' => 3,
        'equipment_type' => 'Projector',
      ],
      [
        'id' => 4,
        'equipment_type' => 'Telephone',
      ],
      [
        'id' => 5,
        'equipment_type' => 'Camera',
      ],
    ];

    DB::table('equipment_types')->insert($data);
  }
}
