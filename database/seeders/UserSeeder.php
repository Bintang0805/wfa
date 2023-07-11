<?php

namespace Database\Seeders;

use App\Models\User\User;
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
        "name" => "Super Admin",
        "email" => "superadmin@gmail.com",
        "contact" => "+628123321123",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 1,
        "verified" => true,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 2,
        "name" => "Admin",
        "email" => "admin@gmail.com",
        "contact" => "+6285155011637",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 2,
        "verified" => false,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 3,
        "name" => "User",
        "email" => "user@example.com",
        "contact" => "+628123456789",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 3,
        "verified" => true,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 4,
        "name" => "Developer",
        "email" => "developer@example.com",
        "contact" => "+628987654321",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 4,
        "verified" => true,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 5,
        "name" => "Tester",
        "email" => "tester@example.com",
        "contact" => "+628111222333",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 5,
        "verified" => false,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 6,
        "name" => "Project Manager",
        "email" => "projectmanager@example.com",
        "contact" => "+628444555666",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 6,
        "verified" => true,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 7,
        "name" => "Network Engineer",
        "email" => "network@example.com",
        "contact" => "+628777888999",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 7,
        "verified" => false,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 8,
        "name" => "System Analyst",
        "email" => "sysanalyst@example.com",
        "contact" => "+628000111222",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 8,
        "verified" => true,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 9,
        "name" => "UI/UX Designer",
        "email" => "designer@example.com",
        "contact" => "+628333444555",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 9,
        "verified" => true,
        "password" => Hash::make("password"),
      ],
      [
        "id" => 10,
        "name" => "IT Support",
        "email" => "support@example.com",
        "contact" => "+628666777888",
        "company_id" => 1,
        "country" => "Indonesia",
        "user_role" => 10,
        "verified" => false,
        "password" => Hash::make("password"),
      ],
    ];

    foreach ($data as $d) {
      $user = User::create($d);
      $user->assignRole($user->role->name);
    }
  }
}
