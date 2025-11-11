<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Actions\Notifications\SendCreateComment;
use App\Models\Comment;
use App\Models\Post;

final readonly class CreateComment
{
    public function __construct(private SendCreateComment $sendCreateComment) {}

    public function handle(Post $post, string $content, ?int $parentId): Comment
    {
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $content,
            'parent_id' => $parentId,
        ]);

        $this->sendCreateComment->handle($comment);

        return $comment;
    }
}
