<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ExistsInUsernameOrEmail implements ValidationRule
{

    Public ?User $user = null {
        get {
            return $this->user;
        }
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->user = User::query()
            ->where('username', $value)
            ->orWhere('email', $value)
            ->first();

        if (! $this->user) {
            $fail('The user does not exist.');
        }
    }
}
