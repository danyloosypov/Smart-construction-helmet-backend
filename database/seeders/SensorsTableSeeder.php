<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\Sensor::create([
            'name' => "temperature",
            'description' => '',
        ]);

        \App\Models\Sensor::create([
            'name' => "humidity",
            'description' => '',
        ]);

        \App\Models\Sensor::create([
            'name' => "gas",
            'description' => '',
        ]);

        \App\Models\Sensor::create([
            'name' => "pulse",
            'description' => '',
        ]);

        \App\Models\Sensor::create([
            'name' => "gps",
            'description' => '',
        ]);

        
    }
}
