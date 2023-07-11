<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
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
          'name' => 'write-users',
        ],
        [
          'id' => '2',
          'name' => 'read-users',
        ],
        [
          'id' => '3',
          'name' => 'write-roles',
        ],
        [
          'id' => '4',
          'name' => 'read-roles',
        ],
        [
          'id' => '5',
          'name' => 'read-companies',
        ],
        [
          'id' => '6',
          'name' => 'write-companies',
        ],
        [
          'id' => '7',
          'name' => 'read-locations',
        ],
        [
          'id' => '8',
          'name' => 'write-locations',
        ],
        [
          'id' => '9',
          'name' => 'read-facilities',
        ],
        [
          'id' => '10',
          'name' => 'write-facilities',
        ],
        [
          'id' => '11',
          'name' => 'read-departments',
        ],
        [
          'id' => '12',
          'name' => 'write-departments',
        ],
        [
          'id' => '13',
          'name' => 'read-equipment_types',
        ],
        [
          'id' => '14',
          'name' => 'write-equipment_types',
        ],
        [
          'id' => '15',
          'name' => 'read-instrument_types',
        ],
        [
          'id' => '16',
          'name' => 'write-instrument_types',
        ],
        [
          'id' => '17',
          'name' => 'read-instruments',
        ],
        [
          'id' => '18',
          'name' => 'write-instruments',
        ],
        [
          'id' => '19',
          'name' => 'read-it_asset_types',
        ],
        [
          'id' => '20',
          'name' => 'write-it_asset_types',
        ],
        [
          'id' => '21',
          'name' => 'read-it_assets',
        ],
        [
          'id' => '22',
          'name' => 'write-it_assets',
        ],
        [
          'id' => '23',
          'name' => 'read-applications',
        ],
        [
          'id' => '24',
          'name' => 'write-applications',
        ],
        [
          'id' => '25',
          'name' => 'read-workflows',
        ],
        [
          'id' => '26',
          'name' => 'write-workflows',
        ],
        [
          'id' => '27',
          'name' => 'read-request_forms',
        ],
        [
          'id' => '28',
          'name' => 'write-request_forms',
        ],
        [
          'id' => '29',
          'name' => 'read-request_workflows',
        ],
        [
          'id' => '30',
          'name' => 'write-request_workflows',
        ],
        [
          'id' => '31',
          'name' => 'read-confirm_workflows',
        ],
        [
          'id' => '32',
          'name' => 'write-confirm_workflows',
        ],
      ];

      $role = Role::whereName("Super Admin")->first();
      foreach ($data as $d) {
        $permission = Permission::create($d);
        $role->givePermissionTo($permission);
      }
    }
}
