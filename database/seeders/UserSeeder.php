<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'name' => 'User' . ($i+1),
                'email' => 'User' . ($i+1) . '@example.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
