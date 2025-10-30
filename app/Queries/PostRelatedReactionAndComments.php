<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

final readonly class PostRelatedReactionAndComments
{
    /**
     * @return Builder<Post>
     */
    public function builder(): Builder
    {
        return Post::query()
            ->withCount('reactions')
            ->with(
                'comments', fn($query) => $query->latest()
                    ->limit(5)
                    ->withCount('reactions'),
                'reactions', fn($query) => $query->whereUserId(auth()->id()),
            )
            ->latest();
    }
}
