<?php

declare(strict_types=1);

namespace App\Http\Controllers\Group;

use App\Actions\Group\JoinToGroup;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;

final class JoinController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Group $group, JoinToGroup $action): RedirectResponse
    {
        $action->handle($group);

        return back()->with('success', 'Your request has been accepted. you will be notified once you will be approved.');
    }
}
