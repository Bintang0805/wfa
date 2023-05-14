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
    \App\Models\User::factory(30)->create();
    \App\Models\masters\Company::factory(1)->create();
  }
}
