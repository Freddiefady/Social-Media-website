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
        return Group::query()->create([
            'name' => $data['name'],
            'about' => $data['about'],
            'auto_approval' => $data['auto_approval'],
            'user_id' => auth()->id(),
        ]);
    }
}
