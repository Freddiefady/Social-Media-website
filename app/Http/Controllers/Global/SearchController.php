<?php

declare(strict_types=1);

namespace App\Http\Controllers\Global;

use App\Actions\Global\SearchGroups;
use App\Actions\Global\SearchPosts;
use App\Actions\Global\SearchUsers;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Http\Resources\Posts\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Response;
use Inertia\ResponseFactory;

final class SearchController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly SearchUsers $searchUsers,
        private readonly SearchPosts $searchPosts,
        private readonly SearchGroups $searchGroups,
    ) {}

    /**
     * Invoke the class instance.
     */
    public function __invoke(Request $request, string $search): Response|ResponseFactory|AnonymousResourceCollection
    {
        $posts = PostResource::collection($this->searchPosts->handle($search));
        if ($request->wantsJson()) {
            return $posts;
        }

        return inertia('Search', [
            'search' => $search,
            'posts' => $posts,
            'users' => UserResource::collection($this->searchUsers->handle($search)),
            'groups' => GroupResource::collection($this->searchGroups->handle($search)),
        ]);
    }
}
