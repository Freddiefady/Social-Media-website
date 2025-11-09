<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\Group;

final readonly class UpdateGroup
{
    /**
     * @param  array<string, mixed>  $validated
     */
    public function handle(Group $group, array $validated): bool
    {
        return $group->update($validated);
    }
}
