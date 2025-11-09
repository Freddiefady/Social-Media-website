<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;

final class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $request->user()?->update([
            'password' => $request->string('password')->toString(),
        ]);

        return back();
    }
}
