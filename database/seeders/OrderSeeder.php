<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 21; $i++) {
            DB::table('orders')->insert([
                'user_id' => random_int(1,5),
                'cadastral_number' => random_int(10,99) . ':' . random_int(10, 99) . ':' . random_int(1000000, 9999999) . ':' . random_int(1000,9999),
                'address' => Str::random(10) . ' область ' . Str::random(20),
                'date_create' => '2024-01-01',
                'date_update' => '2024-05-05',
                'owners' => random_int(1, 19),
                'restrictions' => random_int(1,9),
            ]);
        }
    }
}
