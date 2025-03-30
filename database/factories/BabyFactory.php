<?php

namespace Database\Factories;

use App\Models\Baby;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BabyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Baby::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'birth_date' => fake()->dateTime(),
            'user_id' => User::factory(),
        ];
    }
}
