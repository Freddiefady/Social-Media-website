<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\Group;

final readonly class UpdateGroup
{
    public function handle(Group $group, array $data): bool
    {
        return $group->update($data);
    }
}
