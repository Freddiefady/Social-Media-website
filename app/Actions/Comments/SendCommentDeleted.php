<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;
use App\Notifications\CommentDeleted;

final class SendCommentDeleted
{
    public function handle(Comment $comment): void
    {
        if ($comment->user_id !== auth()->id()) {
            $comment->user->notify(new CommentDeleted($comment));
        }
    }
}
