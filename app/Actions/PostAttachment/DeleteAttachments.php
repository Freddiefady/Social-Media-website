<?php

declare(strict_types=1);

namespace App\Actions\PostAttachment;

use App\Models\Post;

final readonly class DeleteAttachments
{
    public function handle(Post $post, array $deleteIds): void
    {
        if (empty($deleteIds)) {
            return;
        }

        $post->attachments()
            ->whereIn('id', $deleteIds)
            ->get()
            ->each(fn ($attachment) => $attachment->delete());
    }
}
