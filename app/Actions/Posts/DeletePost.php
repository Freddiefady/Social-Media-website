<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;

final readonly class DeletePost
{
    public function handle(Post $post): ?bool
    {
        return $post->delete();
    }
}
