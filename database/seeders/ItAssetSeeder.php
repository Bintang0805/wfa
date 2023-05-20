<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItAssetSeeder extends Seeder
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
        'location_id' => null,
        'facility_id' => null,
        'department_id' => 1,
        'it_asset_type_id' => 1,
        'make' => 'HP',
        'model' => 'EliteBook',
        'oem_sl_no' => '12345',
        'host_name' => 'host001',
        'ip_address' => '192.168.0.1',
        'asset_type' => 'GMP',
        'os_ver' => 'Windows 10',
        'asset_status' => 'Active',
        'owner_name' => 'John Doe',
      ],
      [
        'location_id' => null,
        'facility_id' => null,
        'department_id' => 2,
        'it_asset_type_id' => 2,
        'make' => 'Dell',
        'model' => 'Latitude',
        'oem_sl_no' => '54321',
        'host_name' => 'host002',
        'ip_address' => '192.168.0.2',
        'asset_type' => 'Non GMP',
        'os_ver' => 'Windows 11',
        'asset_status' => 'Retired',
        'owner_name' => 'Jane Smith',
      ],
      [
        'location_id' => null,
        'facility_id' => null,
        'department_id' => 3,
        'it_asset_type_id' => 3,
        'make' => 'Lenovo',
        'model' => 'ThinkPad',
        'oem_sl_no' => '67890',
        'host_name' => 'host003',
        'ip_address' => '192.168.0.3',
        'asset_type' => 'GMP',
        'os_ver' => 'Windows 10',
        'asset_status' => 'Active',
        'owner_name' => 'Robert Johnson',
      ],
      [
        'location_id' => null,
        'facility_id' => null,
        'department_id' => 4,
        'it_asset_type_id' => 4,
        'make' => 'Apple',
        'model' => 'MacBook Pro',
        'oem_sl_no' => '09876',
        'host_name' => 'host004',
        'ip_address' => '192.168.0.4',
        'asset_type' => 'Non GMP',
        'os_ver' => 'macOS Big Sur',
        'asset_status' => 'Stock',
        'owner_name' => 'Emily Williams',
      ],
      [
        'location_id' => null,
        'facility_id' => null,
        'department_id' => 5,
        'it_asset_type_id' => 5,
        'make' => 'Microsoft',
        'model' => 'Surface Pro',
        'oem_sl_no' => '54321',
        'host_name' => 'host005',
        'ip_address' => '192.168.0.5',
        'asset_type' => 'GMP',
        'os_ver' => 'Windows 10',
        'asset_status' => 'Active',
        'owner_name' => 'Michael Brown',
      ],
    ];

    DB::table('it_assets')->insert($data);
  }
}
