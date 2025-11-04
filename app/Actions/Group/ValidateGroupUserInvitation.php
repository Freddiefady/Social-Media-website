<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Enums\GroupUserStatusEnum;
use App\Models\GroupUser;

final readonly class ValidateGroupUserInvitation
{
    public function handle(?GroupUser $groupUser): ?string
    {
        return match (true) {
            ! $groupUser => 'The link is not valid',
            $groupUser->token_used || $groupUser->status === GroupUserStatusEnum::APPROVED->value => 'The link is already used',
            $groupUser->token_expire_date < now() => 'The link is expired',
            default => null,
        };
    }
}
