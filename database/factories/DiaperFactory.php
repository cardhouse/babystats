<?php

namespace Database\Factories;

use App\Models\Baby;
use App\Models\Diaper;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiaperFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Diaper::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['wet', 'dirty', 'full']),
            'date_time' => fake()->dateTime(),
            'baby_id' => Baby::factory(),
        ];
    }
}
