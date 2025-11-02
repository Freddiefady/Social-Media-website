<?php

namespace App\Rules;

use App\Enums\GroupUserStatusEnum;
use App\Models\GroupUser;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UserExists implements ValidationRule
{
    Public ?User $user = null;

    public function __construct(public int $groupId {
        get {
            return $this->groupId;
        }
    })
    {
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $groupUser = GroupUser::query()
            ->where('group_id', $this->groupId)
            ->where('user_id', $this->user->id)
            ->whereStatus(GroupUserStatusEnum::APPROVED->value)
            ->first();

        if ($groupUser) {
            $fail('This user is already a member of the group.');
        }
    }
}
