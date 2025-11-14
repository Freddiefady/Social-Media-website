<?php

declare(strict_types=1);

namespace App\Actions\PostAttachment;

use App\Models\Group;
use App\Models\PostAttachment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class GetPhotosInGroup
{
    /**
     * @return Collection<int, PostAttachment>
     */
    public function handle(Group $group): Collection
    {
        return PostAttachment::query()
            ->whereHas('post', function (Builder $query) use ($group): void {
                // scope to posts that belong to the current group
                $query->where('group_id', $group->id);
            })
            ->whereLike('mime', 'image/%')
            ->latest()
            ->get();
    }
}
