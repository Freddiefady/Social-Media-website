<?php

namespace App\Actions\Group;

use App\Enums\GroupUserRoleEnum;
use App\Enums\GroupUserStatusEnum;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CreateInviteUser
{
    private int $RANDOM_LENGTH = 256;
    private int $TOKEN_EXPIRE_TIME = 24;

    public function handle(Group $group, $userId): GroupUser
    {
        return GroupUser::query()->create([
            'role' => GroupUserRoleEnum::USER->value,
            'status' => GroupUserStatusEnum::PENDING->value,
            'token' => Str::random($this->RANDOM_LENGTH),
            'token_expire_date' => Carbon::now()->addHours($this->TOKEN_EXPIRE_TIME),
            'group_id' => $group->id,
            'user_id' => $userId,
            'created_by' => auth()->id(),
        ]);
    }
}
