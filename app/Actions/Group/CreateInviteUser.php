<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Enums\GroupUserRoleEnum;
use App\Enums\GroupUserStatusEnum;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

final readonly class CreateInviteUser
{
    private int $TOKEN_LENGTH;

    private int $TOKEN_EXPIRE_TIME;

    public function __construct(
        private SendInvitationToUser $invitationToUser,
    ) {
        $this->TOKEN_LENGTH = 256;
        $this->TOKEN_EXPIRE_TIME = 24;
    }

    public function handle(Group $group, User $user): GroupUser
    {
        $token = Str::random($this->TOKEN_LENGTH);

        $groupUser = GroupUser::query()->create([
            'role' => GroupUserRoleEnum::USER->value,
            'status' => GroupUserStatusEnum::PENDING->value,
            'token' => $token,
            'token_expire_date' => Date::now()->addHours($this->TOKEN_EXPIRE_TIME),
            'group_id' => $group->id,
            'user_id' => $user->id,
            'created_by' => auth()->id(),
        ]);

        $this->invitationToUser->handle($user, $group, $token, $this->TOKEN_EXPIRE_TIME);

        return $groupUser;
    }
}
