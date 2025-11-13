<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tickets')->insert([
            ['event_id' => 1, 'name' => 'Presale', 'price' => 250000, 'stock' => 300, 'sold' => 50, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 1, 'name' => 'VIP', 'price' => 750000, 'stock' => 100, 'sold' => 20, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 2, 'name' => 'General', 'price' => 100000, 'stock' => 500, 'sold' => 150, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 2, 'name' => 'Early Bird', 'price' => 80000, 'stock' => 200, 'sold' => 180, 'status' => 'sold_out', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 3, 'name' => 'Regular', 'price' => 75000, 'stock' => 400, 'sold' => 90, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 4, 'name' => 'Online Access', 'price' => 50000, 'stock' => 1000, 'sold' => 300, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 5, 'name' => 'Player Pass', 'price' => 150000, 'stock' => 200, 'sold' => 0, 'status' => 'coming_soon', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 6, 'name' => 'Full Access', 'price' => 350000, 'stock' => 150, 'sold' => 50, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
