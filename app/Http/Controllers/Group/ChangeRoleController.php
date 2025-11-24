<?php

declare(strict_types=1);

namespace App\Http\Controllers\Group;

use App\Actions\Group\ChangeRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\ChangeRoleRequest;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

final class ChangeRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        ChangeRoleRequest $request,
        Group $group,
        ChangeRole $action
    ): Response|RedirectResponse {
        if ($request->user()?->can('is-owner', $group)) {
            return response('You cannot change the role of yourself', 403);
        }

        $action->handle($group, $request->validated());

        return back();
    }
}
