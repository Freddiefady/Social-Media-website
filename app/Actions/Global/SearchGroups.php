<?php

declare(strict_types=1);

namespace App\Actions\Global;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;

final class SearchGroups
{
    /**
     * @return Collection<int, Group>
     */
    public function handle(string $keywords): Collection
    {
        return Group::query()
            ->whereLike('name', "%$keywords%")
            ->orWhereLike('about', "%$keywords%")
            ->latest()
            ->get();
    }
}
