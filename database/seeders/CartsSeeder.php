<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('carts')->insert([
            ['customer_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['customer_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        DB::table('cart_items')->insert([
            ['cart_id' => 1, 'ticket_id' => 1, 'quantity' => 2],
            ['cart_id' => 1, 'ticket_id' => 3, 'quantity' => 1],
            ['cart_id' => 2, 'ticket_id' => 6, 'quantity' => 3],
        ]);
    }
}
