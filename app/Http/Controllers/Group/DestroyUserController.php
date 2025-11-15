<?php

declare(strict_types=1);

namespace App\Http\Controllers\Group;

use App\Actions\GroupUser\DeleteUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\DeleteUserRequest;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

final class DestroyUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DeleteUserRequest $request, Group $group, DeleteUser $action): Response|RedirectResponse
    {
        if ($request->user()?->can('change-role', $request['user_id'])) {
            return response('You cannot remove yourself from the group.', 403);
        }
        $action->handle($group, $request->validated());

        return back();
    }
}
