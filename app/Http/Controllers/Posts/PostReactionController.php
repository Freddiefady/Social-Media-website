<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Actions\CreateReaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\ReactionRequest;
use App\Models\Post;

final class PostReactionController extends Controller
{
    public function __invoke(ReactionRequest $request, Post $post, CreateReaction $action)
    {
        $hasReaction = $action->handle(
            $post,
            $request->string('reaction')->toString()
        );

        return response([
            'num_of_reactions' => $post->reactions()->count(),
            'current_user_has_reaction' => $hasReaction,
        ]);
    }
}
