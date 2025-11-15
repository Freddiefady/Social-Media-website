<?php

declare(strict_types=1);

namespace App\Http\Controllers\Group;

use App\Actions\GroupUser\AcceptInvitation;
use App\Actions\GroupUser\ValidateGroupUserInvitation;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use SensitiveParameter;

final class AcceptInviteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        #[SensitiveParameter] string $token,
        AcceptInvitation $action,
        ValidateGroupUserInvitation $validation
    ): RedirectResponse|Response {
        $groupUser = $action->handle($token);

        $errormessage = $validation->handle($groupUser);

        if ($errormessage) {
            return Inertia::render(component: 'Error', props: [
                'title' => $errormessage,
            ]);
        }

        return to_route('group.show', $groupUser->group)
            ->with('success', "You accepted the invitation to join the group \"$groupUser->group->name\"");
    }
}
