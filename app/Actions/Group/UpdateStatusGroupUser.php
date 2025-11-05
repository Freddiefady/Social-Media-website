<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Enums\GroupUserStatusEnum;
use App\Models\GroupUser;

final readonly class UpdateStatusGroupUser
{
    public function handle(GroupUser $groupUser, array $data): bool
    {
      return $groupUser->update([
            'status' => $data['action'] === GroupUserStatusEnum::APPROVED->value ?
                GroupUserStatusEnum::APPROVED->value :
                GroupUserStatusEnum::REJECTED->value,
        ]);
    }
}
