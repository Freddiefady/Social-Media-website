<?php

namespace App\Http\Controllers\Comments;

use App\Actions\Comments\CreateComment;
use App\Actions\Comments\DeleteComment;
use App\Actions\Comments\UpdateComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreCommentRequest $request,
        Post $post,
        CreateComment $action
    ): Response {
        $comment = $action->handle(
            $post,
            nl2br($request->string('comment')->toString())
        );

        return response($comment, 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateCommentRequest $request,
        Comment $comment,
        UpdateComment $action
    ) {
        $action->handle(
            $comment,
            nl2br($request->string('comment')->toString())
        );

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(
        Comment $comment,
        DeleteComment $action
    ): Response {
        Gate::authorize('delete', $comment);

        $action->handle($comment);

        return response(status: 204);
    }
}
