<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Actions\Posts\CreatePost;
use App\Actions\Posts\DeletePost;
use App\Actions\Posts\UpdatePost;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Resources\Posts\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

final class PostController extends Controller
{
    public function show(Post $post): Response
    {
        $post->loadCount('reactions')
            ->load(['comments' => fn (HasMany $query) => $query->latest()
                ->withCount('reactions'),
            ]);

        return Inertia::render('Posts/Show', [
            'post' => new PostResource($post),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(
        StorePostRequest $request,
        #[CurrentUser] User $loggedInUser,
        CreatePost $action
    ): RedirectResponse {
        DB::transaction(function () use ($request, $loggedInUser, $action): void {
            $post = $action->handle($loggedInUser, $request->validated());
            // Handle attachments if any
            $this->handleAttachments($request, $post);
        });

        return back();
    }

    /**
     * @throws Throwable
     */
    public function update(
        UpdatePostRequest $request,
        Post $post,
        UpdatePost $action
    ): RedirectResponse {
        $action->handle(
            $post,
            $request->validated(),
            $request->array('deleted_file_ids')
        );

        $this->handleAttachments($request, $post);

        return back();
    }

    public function destroy(Post $post, DeletePost $action): RedirectResponse
    {
        Gate::authorize('delete', $post);

        $action->handle($post);

        return back();
    }

    /**
     * @throws Throwable
     */
    private function handleAttachments(StorePostRequest|UpdatePostRequest $request, ?Post $post = null): void
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->store("attachments/$post?->id", 'public');
                $post?->attachments()->create([
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
