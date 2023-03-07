<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'total_distance' => $this->faker->numberBetween(2000, 250000),
            'total_time' => $this->faker->numberBetween(60, 28800),
            'created_at' => $this->faker->dateTimeBetween('-1 week', '+1 week')
        ];
    }
}
