<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
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
        'company_id' => '1',
        'location_name' => '108 Shiv Sagar Est, Goregaon (east)',
      ],
      [
        'id' => '2',
        'company_id' => '1',
        'location_name' => 'Shop No 44, H, Patanwala Mahal, E S Patanwala Marg, Jijamata Udyan, Byculla',
      ],
    ];

    DB::table('locations')->insert($data);
  }
}
