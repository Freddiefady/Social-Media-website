<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;

final readonly class DeleteComment
{
    public function handle(Comment $comment): bool
    {
         return $comment->delete();
    }
}
