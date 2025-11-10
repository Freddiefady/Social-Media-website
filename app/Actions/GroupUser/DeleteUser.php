<?php

declare(strict_types=1);

namespace App\Actions\GroupUser;

use App\Models\Group;
use App\Models\GroupUser;

final readonly class DeleteUser
{
    public function __construct(private SendDeleteUser $sendDeleteUser) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(Group $group, array $data): GroupUser
    {
        $groupUser = GroupUser::query()
            ->where('group_id', $group->id)
            ->where('user_id', $data['user_id'])
            ->firstOrFail();

        $groupUser->delete();
        $this->sendDeleteUser->handle($groupUser);

        return $groupUser;
    }
}
