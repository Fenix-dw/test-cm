<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->realText('100'),
            'content' => fake()->realText(),
            'published' => fake()->boolean,
        ];
    }

}
