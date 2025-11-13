<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_details')->insert([
            ['order_id' => 1, 'ticket_id' => 1, 'quantity' => 2, 'unit_price' => 250000, 'subtotal' => 500000],
            ['order_id' => 1, 'ticket_id' => 3, 'quantity' => 1, 'unit_price' => 150000, 'subtotal' => 150000],
            ['order_id' => 2, 'ticket_id' => 4, 'quantity' => 3, 'unit_price' => 100000, 'subtotal' => 300000],
            ['order_id' => 3, 'ticket_id' => 5, 'quantity' => 1, 'unit_price' => 150000, 'subtotal' => 150000],
        ]);
    }
}
