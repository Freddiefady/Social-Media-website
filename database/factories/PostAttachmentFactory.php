<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<PostAttachment>
 */
final class PostAttachmentFactory extends Factory
{
    protected $model = PostAttachment::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'path' => $this->faker->word(),
            'mime' => $this->faker->word(),
            'created_by' => $this->faker->randomNumber(),
            'created_at' => Date::now(),
            'size' => $this->faker->randomNumber(),

            'post_id' => Post::factory(),
        ];
    }
}
