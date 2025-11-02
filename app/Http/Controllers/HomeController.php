<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Http\Resources\Posts\PostResource;
use App\Queries\PostRelatedReactionAndComments;
use Inertia\Inertia;

final class HomeController extends Controller
{
    public function __invoke()
    {
        $query = new PostRelatedReactionAndComments();

        $posts = $query->builder()->paginate(10);

        $posts = PostResource::collection($posts);
        if (request()->wantsJson()) {
            return $posts;
        }

        $groups = auth()->user()->groups()
                ->orderByPivot('role')
                ->latest('name')
                ->get();

        return Inertia::render('Home', [
            'posts' => $posts,
            'groups' => GroupResource::collection($groups),
        ]);
    }
}
