<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrganizersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organizers')->insert([
            [
                'username' => 'soundwave',
                'email' => 'soundwave@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'SoundWave Live',
                'description' => 'EO konser musik dan festival terbesar di Indonesia.',
                'image_path' => 'storage/organizers/logo1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'eduventure',
                'email' => 'eduventure@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'EduVenture',
                'description' => 'EO seminar dan workshop edukatif.',
                'image_path' => 'storage/organizers/logo2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'gameverse',
                'email' => 'gameverse@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'GameVerse Arena',
                'description' => 'EO kompetisi dan turnamen e-sport.',
                'image_path' => 'storage/organizers/logo3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
