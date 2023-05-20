<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
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
        'application_name' => 'Microsoft Word',
        'application_ver' => '2022',
        'connected_to_computer' => true,
        'location_id' => null,
        'facility_id' => null,
        'department_id' => 1,
        'connected_to_server' => true,
        'application_role_type' => 'Multiple',
        'privilages' => 'Read/Write',
        'manufacturer' => 'Microsoft Corporation',
        'gamp_category' => '3',
        'csv_status' => 'Completed',
        'csv_completed_on' => '2023-05-10 09:00:00',
        'periodic_review' => 'Every 6 months',
        'gxp_status' => 'Yes',
        'backup_mode' => 'Automatic',
        'data_type' => 'Database',
        'vendor_details' => 'Microsoft Licensing',
        'status' => 'Active',
      ],
      [
        'application_name' => 'Adobe Photoshop',
        'application_ver' => '2023',
        'connected_to_computer' => true,
        'location_id' => null,
        'facility_id' => null,
        'department_id' => 2,
        'connected_to_server' => false,
        'application_role_type' => 'Single',
        'privilages' => 'Read/Write',
        'manufacturer' => 'Adobe Inc.',
        'gamp_category' => '4',
        'csv_status' => 'Pending',
        'csv_completed_on' => '2023-05-11 10:00:00',
        'periodic_review' => 'Every 12 months',
        'gxp_status' => 'No',
        'backup_mode' => 'Automatic',
        'data_type' => 'Database',
        'vendor_details' => 'Adobe Licensing',
        'status' => 'Active',
      ],
      [
        'application_name' => 'Google Chrome',
        'application_ver' => '94',
        'connected_to_computer' => true,
        'location_id' => null,
        'facility_id' => null,
        'department_id' => 3,
        'connected_to_server' => false,
        'application_role_type' => 'Single',
        'privilages' => 'Read',
        'manufacturer' => 'Google LLC',
        'gamp_category' => '5',
        'csv_status' => 'On Going',
        'csv_completed_on' => '2023-05-12 11:00:00',
        'periodic_review' => 'Every 12 months',
        'gxp_status' => 'No',
        'backup_mode' => 'Automatic',
        'data_type' => 'Database',
        'vendor_details' => 'ABC Corporation',
        'status' => 'Active',
      ],
    ];

    DB::table('applications')->insert($data);
  }
}
