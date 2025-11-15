<?php

declare(strict_types=1);

namespace App\Http\Controllers\Group;

use App\Actions\Group\CreateInviteUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\InviteUserRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

final class InviteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(InviteUserRequest $request, Group $group, CreateInviteUser $action): RedirectResponse
    {
        $user = $request->getValidatedUser();

        if (! $user instanceof User) {
            return back()->withErrors(['email' => 'User not found']);
        }

        $existsGroupUser = $request->getExistsGroupUser();

        $existsGroupUser?->delete();

        $action->handle($group, $user);

        return back()->with('success', 'User was invited to join to group.');
    }
}
