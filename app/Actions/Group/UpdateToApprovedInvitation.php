<?php

namespace App\Actions\Group;

use App\Enums\GroupUserStatusEnum;
use App\Models\GroupUser;

class UpdateToApprovedInvitation
{
    public function handle(GroupUser $groupUser): bool
    {
        return $groupUser->update([
            'status' => GroupUserStatusEnum::APPROVED->value,
            'token_used' => now(),
        ]);
    }
}
