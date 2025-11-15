<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\Group;

final class CreateGroup
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): Group
    {
        return Group::query()->create($data + [
            'user_id' => auth()->id(),
        ]);
    }
}
