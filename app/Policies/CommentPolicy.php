<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

final class CommentPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): Response
    {
        return $comment->user_id !== $user->id
            ? Response::deny('You do not have permission to delete this comment.', 403)
            : Response::allow();
    }
}
