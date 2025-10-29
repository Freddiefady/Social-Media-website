<?php

declare(strict_types=1);

namespace App\Http\Controllers\Comments;

use App\Actions\CreateReaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\ReactionRequest;
use App\Models\Comment;

final class CommentReactionController extends Controller
{
    public function __invoke(ReactionRequest $request, Comment $comment, CreateReaction $action)
    {
          $hasReaction = $action->handle(
              $comment,
              $request->string('reaction')->toString()
          );

        return response([
            'num_of_reactions' => $comment->reactions()->count(),
            'current_user_has_reaction' => $hasReaction,
        ]);
    }
}
