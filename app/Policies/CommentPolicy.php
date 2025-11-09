<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

final readonly class CommentPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): Response
    {
        return $comment->user_id === $user->id
        || $comment->post->user_id === $user->id

            ? Response::allow()
            : Response::deny('You do not have permission to delete this comment.', 403);
    }
}
