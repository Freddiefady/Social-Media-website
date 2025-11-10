<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\GroupUser;

final readonly class AcceptInvitation
{
    public function __construct(
        private UpdateToApprovedInvitation $updateToApprovedInvitation,
        private SendInvitationApproved $sendInvitationApproved,
    ) {}

    public function handle(string $token): GroupUser
    {
        $groupUser = GroupUser::query()
            ->where('token', $token)
            ->first();

        /** @phpstan-ignore-next-line */
        $this->updateToApprovedInvitation->handle($groupUser);
        /** @phpstan-ignore-next-line */
        $this->sendInvitationApproved->handle($groupUser);

        /** @phpstan-ignore-next-line */
        return $groupUser;
    }
}
