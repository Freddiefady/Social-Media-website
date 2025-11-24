<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

final readonly class PostRelatedReactionAndComments
{
    /**
     * @return Builder<Post>
     */
    public function builder(bool $latest = true): Builder
    {
        $query = Post::query()
            ->withCount('reactions')
            ->with([
                'user',
                'group',
                'group.currentUserGroup',
                'attachments',
                'comments' => fn (Relation $query) => $query->latest()
                    ->with(['user', 'reactions'])
                    ->withCount('reactions'),
                'reactions' => fn (Relation $query) => $query->whereUserId(auth()->id()),
            ]);

        if ($latest) {
            $query->latest();
        }

        return $query;
    }
}
