<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Baby;
use App\Models\Sleep;

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
