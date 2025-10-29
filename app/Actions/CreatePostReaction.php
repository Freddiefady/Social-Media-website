<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Post;
use App\Models\Reaction;

final readonly class CreatePostReaction
{
    public function handle(Post $post, string $type): bool
    {
        $reaction = Reaction::wherePostId($post->id)
            ->whereUserId(auth()->id())
            ->first();

        if ($reaction) {
            $reaction->delete();
            return false;
        }

        Reaction::query()->create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'type' => $type,
        ]);

        return true;
    }
}
