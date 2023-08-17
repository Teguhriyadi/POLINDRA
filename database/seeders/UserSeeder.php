<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "id" => Uuid::uuid4()->getHex(),
            "nama" => "Administrator",
            "email" => "admin@gmail.com",
            "password" => bcrypt("administrator"),
            "role" => "admin",
            "status" => 1
        ]);

        User::create([
            "id" => Uuid::uuid4()->getHex(),
            "nama" => "Wadir",
            "email" => "wadir@gmail.com",
            "password" => bcrypt("wadir123"),
            "role" => "wadir",
            "status" => 1
        ]);

        User::create([
            "id" => Uuid::uuid4()->getHex(),
            "nama" => "Himatif",
            "email" => "himatif@gmail.com",
            "password" => bcrypt("himatif123"),
            "role" => "ormawa",
            "status" => 1
        ]);
    }
}
