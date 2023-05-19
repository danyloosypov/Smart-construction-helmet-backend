<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reading;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(WorkersTableSeeder::class);
        $this->call(HelmetsTableSeeder::class);
        $this->call(SensorsTableSeeder::class);

        //Reading::factory()->count(10)->create();

         \App\Models\User::factory(5)->create();

        /* \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
         ]);*/
    }
}
