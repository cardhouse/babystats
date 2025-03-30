<?php

namespace Database\Factories;

use App\Models\Baby;
use App\Models\Feeding;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feeding::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category' => fake()->randomElement(['breast', 'bottle']),
            'amount' => fake()->numberBetween(30, 180),
            'unit' => fake()->randomElement(['ml', 'oz', 'min']),
            'side' => fake()->randomElement(['left', 'right', 'both']),
            'date_time' => fake()->dateTime(),
            'baby_id' => Baby::factory(),
        ];
    }
}
