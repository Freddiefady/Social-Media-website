<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\Group;
use App\Models\User;
use App\Notifications\InviteInGroup;
use SensitiveParameter;

final readonly class SendInvitationToUser
{
    public function handle(
        User $user,
        Group $group,
        #[SensitiveParameter] string $token,
        int $hours
    ): void {
        $user->notify(new InviteInGroup($group, $token, $hours));
    }
}
