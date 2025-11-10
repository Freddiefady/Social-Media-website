<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Comment;

final class CommentObserver
{
    public function deleting(Comment $comment): void
    {
        // When a comment is deleted, delete all its children
        $comment->comments()->delete();
    }
}
