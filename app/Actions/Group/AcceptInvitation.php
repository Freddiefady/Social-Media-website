<?php

namespace App\Actions\Group;

use App\Models\GroupUser;

final readonly class AcceptInvitation
{
    public function __construct(
        private UpdateToApprovedInvitation  $updateToApprovedInvitation,
        private SendInvitationApproved      $sendInvitationApproved,
    )
    {
    }

    public function handle(string $token): ?GroupUser
    {
        $groupUser = GroupUser::query()
            ->where('token', $token)
            ->first();

        $this->updateToApprovedInvitation->handle($groupUser);

        $this->sendInvitationApproved->handle($groupUser);

        return $groupUser;
    }
}
