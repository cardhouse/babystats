<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Baby;
use App\Models\Feeding;

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
            'type' => fake()->randomElement(["breast","bottle"]),
            'measurement' => fake()->randomElement(["ml","oz","min"]),
            'size' => fake()->word(),
            'side' => fake()->randomElement(["left","right","both"]),
            'date_time' => fake()->dateTime(),
            'baby_id' => Baby::factory(),
        ];
    }
}
