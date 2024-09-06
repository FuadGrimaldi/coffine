<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProduct extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Hot Coffee',
            ],
            [
                'name' => 'Iced Coffee',
            ],
            [
                'name' => 'Tea',
            ],
            [
                'name' => 'Smoothies',
            ],
            [
                'name' => 'Pastries',
            ],
        ]);
    }
}
