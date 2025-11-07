<?php

namespace App\Services;

use App\Models\Group;
use App\Models\User;

class GroupMembershipService
{
    /**
     * Check if user is an approved member of the group
     */
    public function isApprovedMember(Group $group, int|User $user): bool
    {
        $userId = $user instanceof User ? $user->id : $user;

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
        return $this->isApprovedMember($group, $user)
            || $this->isPendingMember($group, $user);
    }

    public function hasRole(Group $group, int $userId): bool
    {
        return $group->user_id === $userId;
    }
}
