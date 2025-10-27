<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;

final readonly class UpdateComment
{
    public function handle(Comment $comment, string $content): bool
    {
        return $comment->update([
            'comment' => $content
        ]);
    }
}
