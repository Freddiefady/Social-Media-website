<?php

declare(strict_types=1);

namespace App\Actions\GroupUser;

use App\Enums\GroupUserStatusEnum;
use App\Models\GroupUser;

final class UpdateToApprovedInvitation
{
    public function handle(GroupUser $groupUser): bool
    {
        return $groupUser->update([
            'status' => GroupUserStatusEnum::APPROVED->value,
            'token_used' => now(),
        ]);
    }
}
