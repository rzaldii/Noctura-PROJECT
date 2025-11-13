<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IssuedTicketsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('issued_tickets')->insert([
            ['order_detail_id' => 1, 'ticket_code' => 'EV1-TK1-001', 'issued_at' => now()],
            ['order_detail_id' => 1, 'ticket_code' => 'EV1-TK1-002', 'issued_at' => now()],
            ['order_detail_id' => 2, 'ticket_code' => 'EV2-TK3-001', 'issued_at' => now()],
            ['order_detail_id' => 4, 'ticket_code' => 'EV5-TK5-001', 'issued_at' => now()],
        ]);
    }
}
