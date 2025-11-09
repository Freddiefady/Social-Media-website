<?php

declare(strict_types=1);

namespace App\Actions\PostAttachment;

use App\Models\Post;

final readonly class DeleteAttachments
{
    /**
     * @param  array<string|int, mixed>  $deleteIds
     */
    public function handle(Post $post, array $deleteIds): void
    {
        if ($deleteIds === []) {
            return;
        }

        $post->attachments()
            ->whereIn('id', $deleteIds)
            ->get()
            ->each(fn ($attachment) => $attachment->delete());
    }
}
