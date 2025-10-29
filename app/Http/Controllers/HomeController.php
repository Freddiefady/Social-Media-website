<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Posts\PostResource;
use App\Models\Post;
use Inertia\Inertia;

final class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = Post::query()
            ->withCount('reactions')
            ->withCount('comments')
            ->with(
                'comments', fn($query) => $query->latest()->limit(5)->withCount('reactions'),
                'reactions', fn($query) => $query->whereUserId(auth()->id()),
                'comments.reactions', fn($query) => $query->whereUserId(auth()->id()),
            )
            ->latest()
            ->paginate(20);

        return Inertia::render('Home', [
            'posts' => PostResource::collection($posts),
        ]);
    }
}
