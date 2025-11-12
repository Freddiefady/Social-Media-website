<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

final class FollowerService
{
    /**
     * Check if current user is following a user
     */
    public function isFollowing(User $user): bool
    {
        return $user->followers()
            ->where('follower_id', auth()->id())
            ->exists();
    }

    /**
     * Follow a user
     */
    public function follow(User $user): void
    {
        if (! $this->isFollowing($user)) {
            $user->followers()->attach(auth()->id());
        }
    }

    /**
     * Unfollow a user
     */
    public function unfollow(User $user): void
    {
        $user->followers()->detach(auth()->id());
    }

    /**
     * Toggle follow/unfollow
     */
    public function toggle(User $user): bool
    {
        $result = $user->followers()->toggle(auth()->id());

        // Returns true if attached, false if detached
        return ! empty($result['attached']);
    }

    /**
     * Get followers count
     */
    public function followersCount(User $user): int
    {
        return $user->followers()->count();
    }

    /**
     * Get following count
     */
    public function followingCount(User $user): int
    {
        return $user->following()->count();
    }
}
