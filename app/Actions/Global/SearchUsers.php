<?php

declare(strict_types=1);

namespace App\Actions\Global;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class SearchUsers
{
    /**
     * @return Collection<int, User>
     */
    public function handle(string $keywords): Collection
    {
        return User::query()
            ->whereLike('name', "%$keywords%")
            ->orWhereLike('username', "%$keywords%")
            ->latest()
            ->get(['id', 'username', 'name']);
    }
}
