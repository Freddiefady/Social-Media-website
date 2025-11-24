<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\Group;

final class DeleteGroup
{
    public function handle(Group $group): Group
    {
        $group->update([
            'deleted_at' => now(),
            'deleted_by' => auth()->id(),
        ]);

        $group->adminUsers()
            ->wherePivot('user_id', (int) auth()->id())
            ->where('group_id', $group->id)
            ->detach();

        return $group;
    }
}
