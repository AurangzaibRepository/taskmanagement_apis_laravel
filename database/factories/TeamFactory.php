<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teamName = fake()->unique()->firstName();

        return [
            'code' => fake()->unique()->uuid(),
            'name' => Str::of('Team ')->append($teamName),
            'description' => fake()->unique()->text(),
        ];
    }
}
