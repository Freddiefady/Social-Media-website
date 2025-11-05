<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\GroupUser;
use App\Notifications\RequestApproved;

final readonly class SendResponseApproval
{
    public function handle(GroupUser $group, bool $data): void
    {
        $group->creator->notify(new RequestApproved($group->group, $data));
    }
}
