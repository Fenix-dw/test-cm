<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'text' => fake()->text(),
            'user_id' => User::factory()->create(),
            'commentable_type' => News::class,
            'commentable_id' => News::factory()->create(),
        ];
    }
}
