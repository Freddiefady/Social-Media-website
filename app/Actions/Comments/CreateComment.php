<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;
use App\Models\Post;

final readonly class CreateComment
{
    public function handle(Post $post, string $content): Comment
    {
        return Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'comment' => $content,
        ]);
    }
}
