<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Group;
use App\Models\User;

final class GroupMembershipService
{
    /**
     * Check if user is an approved member of the group
     */
    public function isApprovedMember(Group $group, User|int $user): bool
    {
        $userId = $user instanceof User ? $user->id : $user;

        if ($userId === null) {
            return false;
        }

        return $group->approvedUsers()
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Check if user has a pending request to join the group
     */
    public function isPendingMember(Group $group, int|User $user): bool
    {
        $userId = $user instanceof User ? $user->id : $user;

        return $group->pendingUsers()
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Check if user is a member (approved or pending)
     */
    public function isMember(Group $group, int|User $user): bool
    {
        if ($this->isApprovedMember($group, $user)) {
            return true;
        }

        return $this->isPendingMember($group, $user);
    }

    /**
     * Check if user is a member admin
     */
    public function isAdmin(Group $group, int|User $user): bool
    {
        return $group->adminUsers()
            ->wherePivot('user_id', $user)
            ->wherePivot('group_id', $group->id)
            ->exists();
    }

    public function isOwner(Group $group, int $userId): bool
    {
        return $group->user_id === $userId;
    }
}
