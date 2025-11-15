<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Actions\Notifications\SendRequestToGroupJoin;
use App\Enums\GroupUserRoleEnum;
use App\Enums\GroupUserStatusEnum;
use App\Models\Group;
use App\Models\GroupUser;

final readonly class JoinToGroup
{
    public function __construct(private SendRequestToGroupJoin $toGroupJoin) {}

    public function handle(Group $group): GroupUser
    {
        $status = GroupUserStatusEnum::APPROVED->value;
        if (! $group->auto_approval) {
            $status = GroupUserStatusEnum::PENDING->value;
            // send email to group join
            $this->toGroupJoin->handle($group);
        }

        return GroupUser::query()->create([
            'role' => GroupUserRoleEnum::USER->value,
            'status' => $status,
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'created_by' => auth()->id(),
        ]);
    }
}
