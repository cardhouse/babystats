<?php

namespace Database\Factories;

use App\Models\Baby;
use App\Models\Sleep;
use Illuminate\Database\Eloquent\Factories\Factory;

class SleepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sleep::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'minutes' => fake()->word(),
            'date_time' => fake()->dateTime(),
            'baby_id' => Baby::factory(),
        ];
    }
}
