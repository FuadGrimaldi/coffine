<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Fuad Grimaldi',
                'email' => 'fuad@gmail.com',
                'address' => 'Jl. Imam Bonjol',
                'phone' => '081234567890',
                'password' => bcrypt('1234fuad'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Team baba',
                'email' => 'aba@gmail.com',
                'address' => 'Jl. Imam Bonjol',
                'phone' => '081234567890',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
