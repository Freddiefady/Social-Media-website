<?php

declare(strict_types=1);

namespace App\Actions\Global;

use App\Models\Post;
use App\Queries\PostRelatedReactionAndComments;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class SearchPosts
{
    public function __construct(private PostRelatedReactionAndComments $query) {}

    /**
     * @return LengthAwarePaginator<int, Post>
     */
    public function handle(string $keywords): LengthAwarePaginator
    {
        return $this->query->builder()
            ->whereLike('body', "%$keywords%")
            ->paginate(20);
    }
}
