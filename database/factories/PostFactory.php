<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
  protected $model = Post::class;

  public function definition(): array
  {
    $title = fake()->sentence(6);

    return [
      'title' => $title,
      'slug' => Str::slug($title),
      'content' => fake()->paragraphs(5, true),
      'user_id' => User::factory(),
      'category_id' => Category::factory(),
      'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
      'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
      'updated_at' => now(),
      'image' => null, // or you can use fake()->imageUrl() for a placeholder image
      'status' => 'pending',
      'reviewed_by' => null,
    ];
  }

  public function draft(): static
  {
    return $this->state(fn(array $attributes) => [
      'published_at' => null,
    ]);
  }

  public function published(): static
  {
    return $this->state(fn(array $attributes) => [
      'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
    ]);
  }
}
