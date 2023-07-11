<?php

namespace Database\Seeders;

use App\Models\masters\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\masters\Company::factory(1)->create();

    $this->call([
      RoleSeeder::class,
      UserSeeder::class,
      LocationSeeder::class,
      FacilitySeeder::class,
      DepartmentSeeder::class,
      EquipmentTypeSeeder::class,
      InstrumentTypeSeeder::class,
      ITAssetTypeSeeder::class,
      InstrumentSeeder::class,
      EquipmentSeeder::class,
      ITAssetSeeder::class,
      ApplicationSeeder::class,
      WorkflowSeeder::class,
      PermissionSeeder::class,
    ]);
  }
}
