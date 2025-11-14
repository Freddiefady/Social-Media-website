<?php

declare(strict_types=1);

namespace App\Actions\PostAttachment;

use App\Models\PostAttachment;
use App\Models\User;
use Illuminate\Support\Collection;

final class GetPhotos
{
    /**
     * @return Collection<int, PostAttachment>
     */
    public function handle(User $user): Collection
    {
        return PostAttachment::query()
            ->where('created_by', $user->id)
            ->whereLike('mime', 'image/%')
            ->latest()
            ->get();
    }
}
