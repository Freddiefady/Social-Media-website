<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Models\GroupUser;
use App\Notifications\ChangeRoleGroup;

final readonly class SendChangeRole
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(GroupUser $groupUser, array $data): void
    {
        assert(is_string($data['role']));
        $groupUser->creator->notify(new ChangeRoleGroup($data['role'], $groupUser->group));
    }
}
