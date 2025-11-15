<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Models\GroupUser;
use App\Notifications\DeletedUserFromGroup;

final class SendDeleteUser
{
    public function handle(GroupUser $groupUser): void
    {
        $groupUser->creator->notify(new DeletedUserFromGroup($groupUser->group));
    }
}
