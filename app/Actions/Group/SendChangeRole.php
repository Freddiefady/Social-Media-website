<?php

declare(strict_types = 1);

namespace App\Actions\Group;

use App\Models\GroupUser;
use App\Notifications\ChangeRoleGroup;

final readonly class SendChangeRole
{
    public function handle(GroupUser $groupUser, array $data): void
    {
        $groupUser->creator->notify(new ChangeRoleGroup($data['role'], $groupUser->group));
    }
}
