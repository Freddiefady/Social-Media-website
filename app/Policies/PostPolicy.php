<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Services\GroupMembershipService;
use Illuminate\Auth\Access\Response;

final readonly class PostPolicy
{
    public function __construct(private GroupMembershipService $membershipService) {}

    public function update(Post $post): bool
    {
        return auth()->id() === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): Response
    {
        return $post->user_id === $user->id
        || $post->group && $this->membershipService->isAdmin($post->group, $user->id)

            ? Response::allow()
            : Response::deny("You don't have permission to delete this post.", 403);
    }
}
