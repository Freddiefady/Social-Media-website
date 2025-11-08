<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<Comment>
 */
final class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'comment' => $this->faker->word(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
            'parent_id' => $this->faker->randomNumber(),

            'post_id' => Post::factory(),
            'user_id' => User::factory(),
        ];
    }
}
