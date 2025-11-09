<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;

final readonly class DeletePost
{
    public function __construct(private SendPostDeleted $sendPostDeleted) {}

    public function handle(Post $post): ?bool
    {
        $this->sendPostDeleted->handle($post);

        return $post->delete();
    }
}
