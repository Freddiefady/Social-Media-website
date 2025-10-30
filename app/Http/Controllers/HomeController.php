<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Posts\PostResource;
use App\Queries\PostRelatedReactionAndComments;
use Inertia\Inertia;

final class HomeController extends Controller
{
    public function __invoke()
    {
        $query = new PostRelatedReactionAndComments();

        $posts = $query->builder()->paginate(20);

        return Inertia::render('Home', [
            'posts' => PostResource::collection($posts),
        ]);
    }
}
