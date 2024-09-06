<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_details')->insert([
            [
                'product_id' => 1,
                'category_id' => 1,
                'price' => 20000,
                'image' => 'cappuccino.jpg',
            ],
            [
                'product_id' => 2,
                'category_id' => 1,
                'price' => 18000,
                'image' => 'cappuccino.jpg',    
            ],
            [
                'product_id' => 3,
                'category_id' => 1,
                'price' => 22000,
                'image' => 'cappuccino.jpg',
            ],
            [
                'product_id' => 4,
                'category_id' => 1,
                'price' => 19000,
                'image' => 'cappuccino.jpg',
            ],
            [
                'product_id' => 5,
                'category_id' => 1,
                'price' => 23000,
                'image' => 'cappuccino.jpg',
            ],
            [
                'product_id' => 6,
                'category_id' => 1,
                'price' => 21000,
                'image' => 'cappuccino.jpg',
            ],
            [
                'product_id' => 7,
                'category_id' => 2,
                'price' => 25000,
                'image' => 'cappuccino.jpg',
            ],
        ]);
    }
}
