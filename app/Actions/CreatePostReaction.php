<?php

declare(strict_types=1);

namespace App\Actions;

use App\Http\Requests\Posts\PostReactionRequest;
use App\Models\Post;
use App\Models\PostReaction;

final readonly class CreatePostReaction
{
    public function handle(Post $post,PostReactionRequest $request): bool
    {
        $reaction = PostReaction::wherePostId($post->id)
            ->whereUserId(auth()->id())
            ->first();

        if ($reaction) {
            $reaction->delete();
            return false;
        }

        PostReaction::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'type' => $request['reaction'],
        ]);

        return true;
    }
}
