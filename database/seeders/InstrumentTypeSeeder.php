<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrumentTypeSeeder extends Seeder
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
        'instrument_type' => 'Guitar',
      ],
      [
        'id' => 2,
        'instrument_type' => 'Piano',
      ],
      [
        'id' => 3,
        'instrument_type' => 'Drums',
      ],
      [
        'id' => 4,
        'instrument_type' => 'Violin',
      ],
      [
        'id' => 5,
        'instrument_type' => 'Saxophone',
      ],
    ];

    DB::table('instrument_types')->insert($data);
  }
}
