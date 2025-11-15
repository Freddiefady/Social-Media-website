<?php

declare(strict_types=1);

namespace App\Http\Controllers\Group;

use App\Actions\Group\FirstApprovedRequests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\ApprovedRequest;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;

final class ApprovedRequestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ApprovedRequest $request, Group $group, FirstApprovedRequests $action): RedirectResponse
    {
        $result = $action->handle($group, $request->validated());

        $message = $result['approved']
            ? "User \"{$result['user']}\" was approved"
            : "User \"{$result['user']}\" was rejected";

        return back()->with('success', $message);
    }
}
