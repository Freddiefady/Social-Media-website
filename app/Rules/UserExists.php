<?php

declare(strict_types=1);

namespace App\Rules;

use App\Enums\GroupUserStatusEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

final class UserExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        auth()->user()?->groups()
            ->wherePivot('group_id', $value)
            ->wherePivot('status', GroupUserStatusEnum::APPROVED->value)
            ->existsOr(fn () => $fail('You don\'t have permission to create post in this group.'));
    }
}
