<?php

namespace App\Http\Controllers\Group;

use App\Actions\Group\AcceptInvitation;
use App\Actions\Group\ChangeRole;
use App\Actions\Group\CreateGroup;
use App\Actions\Group\CreateGroupUser;
use App\Actions\Group\CreateInviteUser;
use App\Actions\Group\FirstApprovedRequests;
use App\Actions\Group\JoinToGroup;
use App\Actions\Group\ValidateGroupUserInvitation;
use App\Actions\Media\CreateCover;
use App\Actions\Media\CreateThumbnail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\ApprovedRequest;
use App\Http\Requests\Group\ChangeRoleRequest;
use App\Http\Requests\Group\InviteUserRequest;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupUserResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\Inertia;
use SensitiveParameter;

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
        $users = $group->approvedUsers()->oldest('name')->get();
        $requests = $group->pendingUsers()->oldest('name')->get();

        return Inertia::render('Group/View', [
            'success' => session('success'),
            'group' => new GroupResource($group->load('currentUserGroup')),
            'users' => GroupUserResource::collection($users),
            'requests' => UserResource::collection($requests),
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
        $success = match (true) {
            $actionCover->handle($user, $request) => 'Your cover image has been updated successfully.',
            $actionThumbnail->handle($user, $request) => 'Your thumbnail image has been updated successfully.',
        };

        return back()->with('success', $success);
    }

    public function invite(InviteUserRequest $request, Group $group, CreateInviteUser $action)
    {
        $user = $request->getValidatedUser();
        $existsGroupUser = $request->getExistsGroupUser();

        $existsGroupUser?->delete();

        $action->handle($group, $user);

        return back()->with('success', 'User was invited to join to group.');
    }

    public function AcceptInvitation(
        #[SensitiveParameter] string $token,
        AcceptInvitation             $action,
        ValidateGroupUserInvitation  $validation
    ): RedirectResponse|Response {
        $groupUser = $action->handle($token);

        $errormessage = $validation->handle($groupUser);

        if ($errormessage) {
            return inertia(component: 'Error', props: [
                'title' => $errormessage
            ]);
        }

        return to_route('group.show', $groupUser->group)
            ->with('success', 'You accepted the invitation to join the group "'.$groupUser->group->name.'"');
    }

    public function join(Group $group, joinToGroup $action)
    {
        $action->handle($group);

        back()->with('success', 'Your request has been accepted. you will be notified once you will be approved.');
    }

    public function approveRequest(ApprovedRequest $request, Group $group, FirstApprovedRequests $action)
    {
//        Gate::authorize('view', [auth()->id(), $group]);

        $result = $action->handle($group, $request->only(['user_id', 'action']));

        $message = $result['approved']
            ? "User \"{$result['user']->name}\" was approved"
            : "User \"{$result['user']->name}\" was rejected";

        return back()->with('success', $message);
    }

    public function changeRole(ChangeRoleRequest $request, Group $group, ChangeRole $action)
    {
        if ($request->user()->can('change-role', $request['user_id'])) {
            return response('You cannot change the role of yourself', 403);
        }

        $action->handle($group, $request->only(['user_id', 'role']));

        return back();
    }
}
