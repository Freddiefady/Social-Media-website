<?php

namespace App\Http\Controllers\Group;

use App\Actions\Group\CreateGroup;
use App\Actions\Group\CreateGroupUser;
use App\Actions\Media\CreateCover;
use App\Actions\Media\CreateThumbnail;
use App\Http\Controllers\Controller;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreGroupRequest $request,
        CreateGroup $action,
        CreateGroupUser $groupUser
    ) {
        $group = $action->handle($request->validated());

        $groupUser->handle($group);

        return response(new GroupResource($group), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
         $group = auth()->user()->groups()->find($group);

        return Inertia::render('Group/View', [
            'success' => session('success'),
            'group' => new GroupResource($group),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }

    public function updateImages(
        MediaRequest $request,
        #[CurrentUser] User $user,
        CreateCover $actionCover,
        CreateThumbnail $actionThumbnail
    ): RedirectResponse {
        $messages = [];

        if ($actionCover->handle($user, $request)) {
            $messages[] = 'Your cover image has been updated successfully.';
        }

        if ($actionThumbnail->handle($user, $request)) {
            $messages[] = 'Your avatar image has been updated successfully.';
        }

        $success = !empty($messages)
            ? implode(' ', $messages)
            : 'No images were updated.';

        return back()->with('success', $success);
    }
}
