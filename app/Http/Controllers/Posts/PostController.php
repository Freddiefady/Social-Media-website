<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Enums\PostReactionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StoreCommentRequest;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\PostReaction;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

final class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $post = auth()->user()->posts()->create($request->validated());
            // Handle attachments if any
            $this->handleAttachments($request, $post);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $post->update($request->validated());
            $delete_ids = $request->input('deleted_file_ids', []);
            // If there are attachments to delete, fetch them
            if (! empty($delete_ids)) {
                $attachments = $post->attachments()
                    ->where('post_id', $post->id)
                    ->whereIn('id', $delete_ids)
                    ->get();
                // Delete attachments
                foreach ($attachments as $attachment) {
                    $attachment->delete();
                }
            }
            // Handle attachments if any
            $this->handleAttachments($request, $post);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return response("You don't have permission to delete this post.", 403);
        }

        $post->delete();

        return back();
    }

    /**
     * Download the specified attachment.
     */
    public function downloadAttachment(PostAttachment $attachment)
    {
        // TODO - check if user has permission to download this attachment
        return response()->download(Storage::disk('public')->path($attachment->path), $attachment->name);
    }

    public function postReaction(Request $request, Post $post)
    {
        $data = $request->validate([
            'reaction' => [Rule::enum(PostReactionEnum::class)],
        ]);

        $reaction = PostReaction::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($reaction) {
            $hasReaction = false;
            $reaction->delete();
        } else {
            $hasReaction = true;
            PostReaction::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'type' => $data['reaction'],
            ]);
        }

        $reactions = PostReaction::where('post_id', $post->id)->count();

        return response([
            'num_of_reactions' => $reactions,
            'current_user_has_reaction' => $hasReaction,
        ]);
    }

    public function createComment(StoreCommentRequest $request, Post $post)
    {
        $comment = Comment::create([
            'comment' => nl2br($request->input('comment')),
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        return response($comment, 201);
    }

    /**
     * Update the given blog post.
     *
     * @throws AuthorizationException
     */
    public function destroyComment(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();
        return response('', 204);
    }

    /**
     * @throws
     */
    private function handleAttachments($request, $post = null): void
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->store('attachments/'.$post->id, 'public');
                $post->attachments()->create([
                    'path' => $filePath,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'created_by' => auth()->id(),
                ]);
            }
        }
        DB::commit();
    }
}
