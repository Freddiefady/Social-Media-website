<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Post;
use App\Models\Reaction;

final readonly class CreateReaction
{
    public function handle(Post $post, string $type): bool
    {
        $reaction = Reaction::whereActionableIdAndActionableType($post->id, $post->getMorphClass())
            ->whereUserId(auth()->id())
            ->first();

        if ($reaction) {
            $reaction->delete();
            return false;
        }

        Reaction::query()->create([
            'actionable_id' => $post->id,
            'actionable_type' => $post->getMorphClass(),
            'user_id' => auth()->id(),
            'type' => $type,
        ]);

        return true;
    }
}
