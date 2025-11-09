<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;
use App\Notifications\PostDeleted;

final class SendPostDeleted
{
    public function handle(Post $post): void
    {
        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new PostDeleted($post->group));
        }
    }
}
