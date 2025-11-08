<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'body' => $this->faker->word(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),

            'user_id' => User::factory(),
            'group_id' => Group::factory(),
            'deleted_by' => User::factory(),
        ];
    }
}
