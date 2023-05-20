<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItAssetTypeSeeder extends Seeder
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
        'it_asset_type' => 'Laptop',
      ],
      [
        'id' => 2,
        'it_asset_type' => 'Desktop',
      ],
      [
        'id' => 3,
        'it_asset_type' => 'Printer',
      ],
      [
        'id' => 4,
        'it_asset_type' => 'Scanner',
      ],
      [
        'id' => 5,
        'it_asset_type' => 'Monitor',
      ],
    ];

    DB::table('it_asset_types')->insert($data);
  }
}
