<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\Group;
use App\Models\GroupUser;

final readonly class ChangeRole
{
    public function __construct(
        private UpdateRoleGroupUser $changeRole,
        private SendChangeRole $sendChangeRole,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(Group $group, array $data): GroupUser
    {
        $query = GroupUser::query()
            ->where('user_id', $data['user_id'])
            ->where('group_id', $group->id)
            ->firstOrFail();

        $this->changeRole->handle($query, $data);
        // Send an email regarding the status of the role
        $this->sendChangeRole->handle($query, $data);

        return $query;
    }
}
