<?php

namespace App\Http\Controllers;

use App\Http\Resources\Posts\PostResource;
use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = Post::query()->latest()->paginate(20);

        return Inertia::render('Home',[
            'posts' => PostResource::collection($posts),
        ]);
    }
}
