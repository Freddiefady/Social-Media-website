<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\GroupUser;

final readonly class UpdateRoleGroupUser
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(GroupUser $groupUser, array $data): bool
    {
        return $groupUser->update(['role' => $data['role']]);
    }
}
