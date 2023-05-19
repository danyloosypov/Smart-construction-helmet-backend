<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reading>
 */
class ReadingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sensor_value' => $this->faker->numberBetween(20, 35),
            'sensor_id' => 1,
            'helmet_id' => 2,
            'created_at' => Carbon::now(),
        ];
    }

    
}
