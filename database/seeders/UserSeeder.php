<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
        "id" => 1,
        "name" => "Admin",
        "email" => "admin@gmail.com",
        "contact" => "+628123321123",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 1,
        "verified" => true,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 2,
        "name" => "Muhammad Ikhsan Bintang",
        "email" => "ikhsanbintang3292@gmail.com",
        "contact" => "+6285155011637",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 2,
        "verified" => false,
        "password" => Hash::make("password"),
      ],
    ];

    DB::table('users')->insert($data);
  }
}
