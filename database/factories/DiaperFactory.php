<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Baby;
use App\Models\Diaper;

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
            'type' => fake()->randomElement(["wet","dirty","full"]),
            'date_time' => fake()->dateTime(),
            'baby_id' => Baby::factory(),
        ];
    }
}
