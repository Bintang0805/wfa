<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
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
        'equipment_type_id' => 1,
        'equipment_name' => 'Laptop',
        'equipment_make' => 'Dell',
        'equipment_model' => 'Latitude',
        'data_storage' => 'Yes',
        'indirect_impact' => 'No',
        'qualification_status' => 'Completed',
        'csv_status' => 'Pending',
        'equipment_number' => 'EQP-001',
        'status' => true,
      ],
      [
        'location_id' => 1,
        'facility_id' => 1,
        'department_id' => 2,
        'equipment_type_id' => 2,
        'equipment_name' => 'Projector',
        'equipment_make' => 'Epson',
        'equipment_model' => 'PowerLite',
        'data_storage' => 'No',
        'indirect_impact' => 'Yes',
        'qualification_status' => 'On Going',
        'csv_status' => 'Completed',
        'equipment_number' => 'EQP-002',
        'status' => true,
      ],
      [
        'location_id' => 2,
        'facility_id' => 3,
        'department_id' => 3,
        'equipment_type_id' => 3,
        'equipment_name' => 'Printer',
        'equipment_make' => 'HP',
        'equipment_model' => 'LaserJet',
        'data_storage' => 'NA',
        'indirect_impact' => 'No',
        'qualification_status' => 'Pending',
        'csv_status' => 'On Going',
        'equipment_number' => 'EQP-003',
        'status' => true,
      ],
      [
        'location_id' => 2,
        'facility_id' => 4,
        'department_id' => 4,
        'equipment_type_id' => 4,
        'equipment_name' => 'Scanner',
        'equipment_make' => 'Canon',
        'equipment_model' => 'CanoScan',
        'data_storage' => 'Yes',
        'indirect_impact' => 'Yes',
        'qualification_status' => 'NA',
        'csv_status' => 'Pending',
        'equipment_number' => 'EQP-004',
        'status' => true,
      ],
      [
        'location_id' => 2,
        'facility_id' => 5,
        'department_id' => 5,
        'equipment_type_id' => 5,
        'equipment_name' => 'Server',
        'equipment_make' => 'Dell',
        'equipment_model' => 'PowerEdge',
        'data_storage' => 'No',
        'indirect_impact' => 'NA',
        'qualification_status' => 'On Going',
        'csv_status' => 'Completed',
        'equipment_number' => 'EQP-005',
        'status' => true,
      ],
    ];

    DB::table('equipments')->insert($data);
  }
}
