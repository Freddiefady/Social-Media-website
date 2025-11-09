<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;
use App\Models\User;

final readonly class CreatePost
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(User $user, array $data): Post
    {
        return $user->posts()->create($data);
    }
}
