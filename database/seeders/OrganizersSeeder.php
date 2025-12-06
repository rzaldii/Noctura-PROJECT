<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrganizersSeeder extends Seeder
{
    public function run(): void
    {
        $organizers = [
            [
                'username' => 'soundwave',
                'email' => 'soundwave@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'SoundWave Live',
                'description' => 'EO konser musik dan festival terbesar di Indonesia.',
                'image_path' => 'storage/organizers/logo1.png',
            ],
            [
                'username' => 'eduventure',
                'email' => 'eduventure@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'EduVenture',
                'description' => 'EO seminar dan workshop edukatif.',
                'image_path' => 'storage/organizers/logo2.png',
            ],
            [
                'username' => 'gameverse',
                'email' => 'gameverse@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'GameVerse Arena',
                'description' => 'EO kompetisi dan turnamen e-sport.',
                'image_path' => 'storage/organizers/logo3.png',
            ],
            // baru
            [
                'username' => 'rhythmnation',
                'email' => 'rhythmnation@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'Rhythm Nation',
                'description' => 'EO konser musik modern dan festival genre pop-electronic.',
                'image_path' => 'storage/organizers/logo4.png',
            ],
            [
                'username' => 'progamersid',
                'email' => 'progamersid@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'ProGamers Indonesia',
                'description' => 'EO turnamen e-sport profesional tingkat nasional.',
                'image_path' => 'storage/organizers/logo5.png',
            ],
            [
                'username' => 'sciencelab',
                'email' => 'sciencelab@mail.com',
                'password' => Hash::make('123'),
                'organization_name' => 'Science Lab Community',
                'description' => 'EO seminar dan expo ilmu pengetahuan serta teknologi terbaru.',
                'image_path' => 'storage/organizers/logo6.png',
            ],
        ];

        foreach ($organizers as $org) {
            // cek apakah email sudah ada
            $existing = DB::table('organizers')->where('email', $org['email'])->first();

            if ($existing) {
                // update (created_at tetap)
                DB::table('organizers')->where('email', $org['email'])->update([
                    'username' => $org['username'],
                    'password' => $org['password'],
                    'organization_name' => $org['organization_name'],
                    'description' => $org['description'],
                    'image_path' => $org['image_path'],
                    'updated_at' => now(),
                ]);
            } else {
                // insert baru
                DB::table('organizers')->insert(array_merge($org, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
