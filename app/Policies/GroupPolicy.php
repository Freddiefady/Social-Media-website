<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use App\Services\GroupMembershipService;
use Illuminate\Auth\Access\Response;
use Illuminate\Container\Attributes\CurrentUser;

final readonly class GroupPolicy
{
    public function __construct(private GroupMembershipService $membershipService) {}

    /**
     * Determine whether the user can view the model.
     */
    public function viewAny(
        #[CurrentUser] User $user,
        Group $group
    ): Response {
        return $this->membershipService->isAdmin($group, $user->id)
            ? Response::allow()
            : Response::deny('you don\'t have permission to perform this action', 403);
    }

    public function changeRole(Group $group, int $userId): bool
    {
        return $this->membershipService->isOwner($group, $userId);
    }
}
