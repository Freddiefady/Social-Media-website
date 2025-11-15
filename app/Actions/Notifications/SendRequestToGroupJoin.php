<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Models\Group;
use App\Notifications\GroupJoinRequest;
use Illuminate\Support\Facades\Notification;

final readonly class SendRequestToGroupJoin
{
    public function handle(Group $group): void
    {
        Notification::send($group->adminUsers, new GroupJoinRequest($group));
    }
}
