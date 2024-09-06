<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Cappuccino',
                'stock' => 10,
                'description' => 'A classic Italian coffee drink with espresso and steamed milk foam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Espresso',
                'stock' => 15,
                'description' => 'A concentrated form of coffee served in small, strong shots',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Latte',
                'stock' => 12,
                'description' => 'Espresso with steamed milk and a small layer of milk foam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Americano',
                'stock' => 20,
                'description' => 'Espresso diluted with hot water',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mocha',
                'stock' => 8,
                'description' => 'A chocolate-flavored variant of a latte',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Macchiato',
                'stock' => 10,
                'description' => 'Espresso with a small amount of foamed milk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cold Brew',
                'stock' => 15,
                'description' => 'Coffee brewed with cold water over several hours',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
