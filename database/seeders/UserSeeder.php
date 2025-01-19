<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'test',
                'email' => 'test@gmail.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'test2',
                'email' => 'test2@gmail.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'test3',
                'email' => 'test3@gmail.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => Str::random(10),
                'email' => 'test4@gmail.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => Str::random(10),
                'email' => 'test5@gmail.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => Str::random(10),
                'email' => 'test6@gmail.com',
                'password' => Hash::make('password123')
            ],
        ]);
    }
}
