<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->unique()->text(10),
            'content' => fake()->text(40),
            'user_id' => fake()->unique()->numberBetween(1, 50),

        ];
        Post::factory()
            ->count(20)
            ->create();
    }
}
