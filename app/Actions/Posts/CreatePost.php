<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Actions\Notifications\SendCreatePost;
use App\Models\Post;
use App\Models\User;

final readonly class CreatePost
{
    public function __construct(private SendCreatePost $sendCreatePost) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(User $user, array $data): Post
    {
        $post = $user->posts()->create($data);

        $this->sendCreatePost->handle($post, $user);

        return $post;
    }
}
