<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'username' => 'rizky',
                'email' => 'rizky@mail.com',
                'password' => Hash::make('123'),
                'full_name' => 'Rizky Aditya',
                'image_path' => 'storage/customers/profile1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'anita',
                'email' => 'anita@mail.com',
                'password' => Hash::make('123'),
                'full_name' => 'Anita Lestari',
                'image_path' => 'storage/customers/profile2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'dimas',
                'email' => 'dimas@mail.com',
                'password' => Hash::make('123'),
                'full_name' => 'Dimas Prayoga',
                'image_path' => 'storage/customers/profile3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'laila',
                'email' => 'laila@mail.com',
                'password' => Hash::make('123'),
                'full_name' => 'Laila Rahma',
                'image_path' => 'storage/customers/profile4.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'yoga',
                'email' => 'yoga@mail.com',
                'password' => Hash::make('123'),
                'full_name' => 'Yoga Saputra',
                'image_path' => 'storage/customers/profile5.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
