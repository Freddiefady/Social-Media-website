<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;

final readonly class PostPinGroup
{
    /**
     * @throws Throwable
     */
    public function handle(Post $post): bool
    {
        // Load group if not already loaded
        $post->loadMissing('group');

        Gate::forUser(auth()->user())
            ->authorize('pinToGroup', $post);

        return DB::transaction(function () use ($post): bool {
            $group = $post->group;
            $isPinning = $group->pinned_post_id !== $post->id;

            $group->update(['pinned_post_id' => $isPinning ? $post->id : null]);

            return $isPinning;
        });
    }
}
