<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Followers\ToggleFollowerUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

final class FollowerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, ToggleFollowerUser $action): RedirectResponse
    {
        $isNowFollower = $action->handle($user);

        return back()->with('success', $isNowFollower
            ? "You are now following $user->name"
            : "You unfollowed $user->name"
        );
    }
}
