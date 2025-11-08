<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Enums\GroupUserRoleEnum;
use App\Enums\GroupUserStatusEnum;
use App\Models\Group;
use App\Models\GroupUser;

final class CreateGroupUser
{
    public function handle(Group $group)
    {
        return GroupUser::query()->create([
            'status' => GroupUserStatusEnum::APPROVED->value,
            'role' => GroupUserRoleEnum::ADMIN->value,
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'created_by' => auth()->id(),
        ]);
    }
}
