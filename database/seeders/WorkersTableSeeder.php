<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Worker::create([
            'name' => "Danylo",
            'username' => 'user1',
            'password' => 'user1',
        ]);

        \App\Models\Worker::create([
            'name' => "Petro",
            'username' => 'user2',
            'password' => 'user2',
        ]);

        \App\Models\Worker::create([
            'name' => "Vasyl",
            'username' => 'user3',
            'password' => 'user3',
        ]);

        \App\Models\Worker::create([
            'name' => "Denis",
            'username' => 'user4',
            'password' => 'user4',
        ]);

        
    }
}
