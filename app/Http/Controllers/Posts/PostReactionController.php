<?php

namespace App\Http\Controllers\Posts;

use App\Actions\CreatePostReaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\PostReactionRequest;
use App\Models\Post;

class PostReactionController extends Controller
{
    public function __invoke(PostReactionRequest $request, Post $post, CreatePostReaction $action)
    {
        $hasReaction = $action->handle($post, $request);

        return response([
            'num_of_reactions' => $post->reactions()->count(),
            'current_user_has_reaction' => $hasReaction,
        ]);
    }
}
