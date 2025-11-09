<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;

final readonly class DeleteComment
{
    public function __construct(private SendCommentDeleted $sendCommentDeleted) {}

    public function handle(Comment $comment): ?bool
    {
        $this->sendCommentDeleted->handle($comment);

        return $comment->delete();
    }
}
