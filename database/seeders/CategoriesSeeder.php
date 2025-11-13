<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Concert',
                'description' => 'Event musik dan hiburan besar.',
                'image_path' => 'storage/categories/concert.png'
            ],
            [
                'name' => 'Seminar',
                 'description' => 'Event edukatif formal.',
                  'image_path' => 'storage/categories/seminar.png'
            ],
            [
                'name' => 'Performance',
                'description' => 'Pertunjukan seni dan teater.',
                 'image_path' => 'storage/categories/performance.png'
            ],
            [
                'name' => 'Competition',
                 'description' => 'Turnamen dan lomba.',
                  'image_path' => 'storage/categories/competition.png'
            ],
            [
                'name' => 'Training',
                'description' => 'Workshop dan pelatihan.',
                'image_path' => 'storage/categories/training.png'
            ],
        ]);
    }
}
