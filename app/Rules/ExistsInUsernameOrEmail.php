<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

final class ExistsInUsernameOrEmail implements ValidationRule
{
    public ?User $user = null {
        get {
            return $this->user;
        }
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->user = User::query()
            ->where('username', $value)
            ->orWhere('email', $value)
            ->first();

        if (! $this->user instanceof User) {
            $fail('The user does not exist.');
        }
    }
}
