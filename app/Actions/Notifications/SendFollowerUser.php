<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Models\User;
use App\Notifications\FollowerUser;

final class SendFollowerUser
{
    public function handle(User $user, bool $follow): void
    {
        $user->notify(new FollowerUser($user, $follow));
    }
}
