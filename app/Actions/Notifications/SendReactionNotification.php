<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\ReactionOnComment;
use App\Notifications\ReactionOnPost;
use Illuminate\Database\Eloquent\Model;

final class SendReactionNotification
{
    public function handle(Model $model): void
    {
        match (true) {
            $model instanceof Post => $this->sendPostReaction($model),
            $model instanceof Comment => $this->sendCommentReaction($model),
            default => null,
        };
    }

    private function sendPostReaction(Post $post): void
    {
        // Don't notify if user reacted to their own post
        if ($post->user_id === auth()->id()) {
            return;
        }

        $post->user->notify(new ReactionOnPost($post, $post->user));
    }

    private function sendCommentReaction(Comment $comment): void
    {
        // Don't notify if user reacted to their own comment
        if ($comment->user_id === auth()->id()) {
            return;
        }

        $comment->user->notify(new ReactionOnComment($comment, $comment->user, $comment->post));
    }
}
