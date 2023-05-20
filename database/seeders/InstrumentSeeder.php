<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrumentSeeder extends Seeder
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
        'location_id' => 1,
        'facility_id' => 1,
        'department_id' => 1,
        'instrument_type_id' => 1,
        'instrument_name' => 'Acoustic Guitar',
        'instrument_make' => 'Gibson',
        'instrument_model' => 'J-45',
        'data_storage' => 'Yes',
        'indirect_impact' => 'No',
        'qualification_status' => 'Completed',
        'csv_status' => 'Pending',
        'computer_connected' => 'Yes',
        'instrument_asset_code' => 'INS-001',
        'status' => true,
      ],
      [
        'location_id' => 1,
        'facility_id' => 1,
        'department_id' => 2,
        'instrument_type_id' => 2,
        'instrument_name' => 'Grand Piano',
        'instrument_make' => 'Steinway & Sons',
        'instrument_model' => 'Model D',
        'data_storage' => 'No',
        'indirect_impact' => 'Yes',
        'qualification_status' => 'On Going',
        'csv_status' => 'Completed',
        'computer_connected' => 'No',
        'instrument_asset_code' => 'INS-002',
        'status' => true,
      ],
      [
        'location_id' => 2,
        'facility_id' => 3,
        'department_id' => 3,
        'instrument_type_id' => 3,
        'instrument_name' => 'Drum Set',
        'instrument_make' => 'Pearl',
        'instrument_model' => 'Masterworks',
        'data_storage' => 'NA',
        'indirect_impact' => 'No',
        'qualification_status' => 'Pending',
        'csv_status' => 'On Going',
        'computer_connected' => 'NA',
        'instrument_asset_code' => 'INS-003',
        'status' => true,
      ],
      [
        'location_id' => 2,
        'facility_id' => 4,
        'department_id' => 4,
        'instrument_type_id' => 4,
        'instrument_name' => 'Violin',
        'instrument_make' => 'Stradivarius',
        'instrument_model' => 'Antonio Stradivari',
        'data_storage' => 'Yes',
        'indirect_impact' => 'Yes',
        'qualification_status' => 'NA',
        'csv_status' => 'Pending',
        'computer_connected' => 'No',
        'instrument_asset_code' => 'INS-004',
        'status' => true,
      ],
      [
        'location_id' => 2,
        'facility_id' => 5,
        'department_id' => 5,
        'instrument_type_id' => 5,
        'instrument_name' => 'Saxophone',
        'instrument_make' => 'Yamaha',
        'instrument_model' => 'YAS-62',
        'data_storage' => 'No',
        'indirect_impact' => 'NA',
        'qualification_status' => 'On Going',
        'csv_status' => 'Completed',
        'computer_connected' => 'Yes',
        'instrument_asset_code' => 'INS-005',
        'status' => true,
      ],
    ];

    DB::table('instruments')->insert($data);
  }
}
