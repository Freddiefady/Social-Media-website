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
    public function builder(bool $latest = true): Builder
    {
        $query = Post::query()
            ->withCount('reactions')
            ->with(
                'comments', fn ($query) => $query->latest()
                    ->withCount('reactions'),
                'reactions', fn ($query) => $query->whereUserId(auth()->id()),
            );

        if ($latest) {
            $query->latest();
        }

        return $query;
    }
}
