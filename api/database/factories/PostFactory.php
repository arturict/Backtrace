<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition(): array
    {
        $title = fake()->sentence();
        
        return [
            'title' => $title,
            'body' => fake()->paragraphs(3, true),
            'author' => fake()->name(),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'slug' => Str::slug($title) . '-' . fake()->unique()->randomNumber(5),
            'views' => fake()->numberBetween(0, 1000),
            'topic_id' => Topic::factory(),
            'user_id' => User::factory(),
        ];
    }
}