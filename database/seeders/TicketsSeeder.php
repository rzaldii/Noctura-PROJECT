<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketsSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = [
            ['event_id' => 1, 'name' => 'Presale', 'price' => 250000, 'stock' => 300, 'sold' => 50, 'status' => 'available'],
            ['event_id' => 1, 'name' => 'VIP', 'price' => 750000, 'stock' => 100, 'sold' => 20, 'status' => 'available'],
            ['event_id' => 2, 'name' => 'General', 'price' => 100000, 'stock' => 500, 'sold' => 150, 'status' => 'available'],
            ['event_id' => 2, 'name' => 'Early Bird', 'price' => 80000,  'stock' => 200, 'sold' => 180, 'status' => 'sold_out'],
            ['event_id' => 3, 'name' => 'Regular', 'price' => 75000,  'stock' => 400, 'sold' => 90,  'status' => 'available'],
            ['event_id' => 4, 'name' => 'Online Access', 'price' => 50000,  'stock' => 1000, 'sold' => 300, 'status' => 'available'],
            ['event_id' => 5, 'name' => 'Player Pass', 'price' => 150000, 'stock' => 200, 'sold' => 0,   'status' => 'coming_soon'],
            ['event_id' => 6, 'name' => 'Full Access', 'price' => 350000, 'stock' => 150, 'sold' => 50,  'status' => 'available'],
            ['event_id' => 7, 'name' => 'Presale', 'price' => 150000, 'stock' => 300, 'sold' => 120, 'status' => 'available'],
            ['event_id' => 7, 'name' => 'Regular', 'price' => 250000, 'stock' => 200, 'sold' => 90,  'status' => 'available'],
            ['event_id' => 7, 'name' => 'VIP', 'price' => 400000, 'stock' => 80,  'sold' => 60,  'status' => 'available'],
            ['event_id' => 8, 'name' => 'Early Bird', 'price' => 75000,  'stock' => 300, 'sold' => 300, 'status' => 'sold_out'],
            ['event_id' => 8, 'name' => 'Regular', 'price' => 125000, 'stock' => 250, 'sold' => 200, 'status' => 'available'],
            ['event_id' => 8, 'name' => 'Premium Access', 'price' => 220000, 'stock' => 100, 'sold' => 0,   'status' => 'coming_soon'],
            ['event_id' => 9, 'name' => 'Online Access', 'price' => 50000,  'stock' => 1000, 'sold' => 450, 'status' => 'available'],
            ['event_id' => 9, 'name' => 'Workshop Pass', 'price' => 150000, 'stock' => 200,  'sold' => 85,  'status' => 'available'],
            ['event_id' => 10, 'name' => 'General', 'price' => 50000, 'stock' => 500, 'sold' => 230, 'status' => 'available'],
            ['event_id' => 10, 'name' => 'Art Experience Pass', 'price' => 120000, 'stock' => 200, 'sold' => 100, 'status' => 'available'],
            ['event_id' => 10, 'name' => 'VIP Gallery', 'price' => 250000, 'stock' => 50, 'sold' => 32, 'status' => 'available'],
            ['event_id' => 11, 'name' => 'Presale', 'price' => 60000, 'stock' => 400, 'sold' => 180, 'status' => 'available'],
            ['event_id' => 11, 'name' => 'Regular', 'price' => 100000, 'stock' => 300, 'sold' => 150, 'status' => 'available'],
            ['event_id' => 11, 'name' => 'Mentoring Pass', 'price' => 180000, 'stock' => 100, 'sold' => 40, 'status' => 'available'],
            ['event_id' => 12, 'name' => 'Presale', 'price' => 175000, 'stock' => 400, 'sold' => 400, 'status' => 'sold_out'],
            ['event_id' => 12, 'name' => 'Regular', 'price' => 250000, 'stock' => 300, 'sold' => 150, 'status' => 'available'],
            ['event_id' => 12, 'name' => 'VIP', 'price' => 375000, 'stock' => 70, 'sold' => 0,   'status' => 'coming_soon'],
            ['event_id' => 13, 'name' => 'General Access', 'price' => 50000,  'stock' => 600, 'sold' => 300, 'status' => 'available'],
            ['event_id' => 13, 'name' => 'Competition Pass', 'price' => 150000, 'stock' => 150, 'sold' => 75, 'status' => 'available'],
            ['event_id' => 14, 'name' => 'Basic Access', 'price' => 35000,  'stock' => 500, 'sold' => 250, 'status' => 'available'],
            ['event_id' => 14, 'name' => 'Full Bootcamp Pass', 'price' => 200000, 'stock' => 120, 'sold' => 60, 'status' => 'available'],
            ['event_id' => 15, 'name' => 'Retro Pass', 'price' => 45000,  'stock' => 350, 'sold' => 350, 'status' => 'sold_out'],
            ['event_id' => 15, 'name' => 'Competition Ticket', 'price' => 90000,  'stock' => 200, 'sold' => 0,   'status' => 'coming_soon'],
            ['event_id' => 15, 'name' => 'Collector VIP', 'price' => 200000, 'stock' => 50,  'sold' => 20,  'status' => 'available'],
        ];

        foreach ($tickets as $ticket) {
            $existing = DB::table('tickets')
                ->where('event_id', $ticket['event_id'])
                ->where('name', $ticket['name'])
                ->first();

            if ($existing) {
                DB::table('tickets')
                    ->where('event_id', $ticket['event_id'])
                    ->where('name', $ticket['name'])
                    ->update([
                        'price' => $ticket['price'],
                        'stock' => $ticket['stock'],
                        'sold' => $ticket['sold'],
                        'status' => $ticket['status'],
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('tickets')->insert(array_merge($ticket, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
