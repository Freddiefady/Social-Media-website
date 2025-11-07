<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Container\Attributes\CurrentUser;

class GroupPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function viewAny(
        #[CurrentUser] User $user,
        Group $group
    ): Response {
        return $group->adminUsers()
            ->wherePivot('user_id', $user->id)
            ->wherePivot('group_id', $group->id)
            ->exists()
            ? Response::allow()
            : Response::deny('you don\'t have permission to perform this action', 403);
    }

    public function changeRole(Group $group, int $userId): bool
    {
        return $group->user_id === $userId;
    }
}
