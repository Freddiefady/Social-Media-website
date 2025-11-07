<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Enums\GroupUserStatusEnum;
use App\Models\Group;
use App\Models\GroupUser;

final readonly class FirstApprovedRequests
{
    public function __construct(
        private UpdateStatusGroupUser $updateStatusGroupUser,
        private SendResponseApproval $sendResponseApproval,
    ) {}

    public function handle(Group $group, array $data): array
    {
        $query = GroupUser::query()
            ->where('user_id', $data['user_id'])
            ->where('group_id', $group->id)
            ->where('status', GroupUserStatusEnum::PENDING->value)
            ->first();

        if ($query) {
            $this->updateStatusGroupUser->handle($query, $data);
            // Send email
            $approved = $data['action'] === 'approved';
            $this->sendResponseApproval->handle($query, $approved);

            return [
                'groupUser' => $query,
                'user' => $query->user,
                'approved' => $approved,
            ];
        }

        return [
            'groupUser' => null,
            'user' => null,
            'approved' => false,
        ];
    }
}
