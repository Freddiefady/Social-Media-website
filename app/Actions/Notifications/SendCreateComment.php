<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Models\Comment;
use App\Notifications\CommentCreated;

final class SendCreateComment
{
    public function handle(Comment $comment): void
    {
        $comment->user->notify(new CommentCreated($comment));
    }
}
