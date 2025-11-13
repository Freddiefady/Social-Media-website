<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Http\Resources\Posts\PostResource;
use App\Http\Resources\UserResource;
use App\Queries\RelevantPostsTimeline;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;

final class HomeController extends Controller
{
    public function __construct(private readonly RelevantPostsTimeline $relevantPostsTimeline) {}

    public function __invoke(): AnonymousResourceCollection|Response
    {
        $posts = $this->relevantPostsTimeline->builder()->paginate(10);

        $posts = PostResource::collection($posts);
        if (request()->wantsJson()) {
            return $posts;
        }

        $groups = auth()->user()?->groups()
            ->orderByPivot('role')
            ->latest('name')
            ->get();

        return Inertia::render('Home', [
            'posts' => $posts,
            'groups' => GroupResource::collection($groups),
            'followers' => UserResource::collection(auth()->user()->followers),
        ]);
    }
}
