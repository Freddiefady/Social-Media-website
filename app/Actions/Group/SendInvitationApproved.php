<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\GroupUser;
use App\Notifications\InvitationApproved;

final readonly class SendInvitationApproved
{
    public function handle(GroupUser $groupUser): void
    {
        $groupUser->creator->notify(new InvitationApproved($groupUser->group));
    }
}
