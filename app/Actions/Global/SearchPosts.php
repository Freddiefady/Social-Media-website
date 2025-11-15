<?php

declare(strict_types=1);

namespace App\Actions\Global;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

final class SearchPosts
{
    /**
     * @return LengthAwarePaginator<int, Post>
     */
    public function handle(string $keywords): LengthAwarePaginator
    {
        return Post::query()
            ->whereLike('body', "%$keywords%")
            ->latest()
            ->paginate(20);
    }
}
