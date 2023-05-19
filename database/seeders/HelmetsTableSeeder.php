<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HelmetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Helmet::create([
            'name' => "builder",
            'description' => '',
            'worker_id' => '1',
        ]);

        \App\Models\Helmet::create([
            'name' => "builder",
            'description' => '',
            'worker_id' => '2',
        ]);

        \App\Models\Helmet::create([
            'name' => "builder",
            'description' => '',
            'worker_id' => '3',
        ]);

        \App\Models\Helmet::create([
            'name' => "builder",
            'description' => '',
            'worker_id' => '4',
        ]);

    }
}
