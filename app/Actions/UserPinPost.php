<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Throwable;

final class UserPinPost
{
    /**
     * @throws Throwable
     */
    public function handle(Post $post): bool
    {
        $user = auth()->user();

        return DB::transaction(function () use ($post, $user): bool {
            $isPinning = $user?->pinned_post_id !== $post->id;

            $user?->update(['pinned_post_id' => $isPinning ? $post->id : null]);

            return $isPinning;
        });
    }
}
