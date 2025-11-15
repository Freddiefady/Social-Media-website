<?php

declare(strict_types=1);

namespace App\Http\Controllers\Group;

use App\Actions\Group\ChangeRole;
use App\Actions\Group\CreateGroup;
use App\Actions\Group\CreateInviteUser;
use App\Actions\Group\FirstApprovedRequests;
use App\Actions\Group\JoinToGroup;
use App\Actions\Group\showGroup;
use App\Actions\Group\UpdateGroup;
use App\Actions\GroupUser\AcceptInvitation;
use App\Actions\GroupUser\CreateGroupUser;
use App\Actions\GroupUser\DeleteUser;
use App\Actions\GroupUser\ValidateGroupUserInvitation;
use App\Actions\Media\CreateCover;
use App\Actions\Media\CreateThumbnail;
use App\Actions\PostAttachment\GetPhotosInGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\ApprovedRequest;
use App\Http\Requests\Group\ChangeRoleRequest;
use App\Http\Requests\Group\DeleteUserRequest;
use App\Http\Requests\Group\InviteUserRequest;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupUserResource;
use App\Http\Resources\PostAttachment\PostAttachmentResource;
use App\Http\Resources\Posts\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;
use SensitiveParameter;

final class GroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreGroupRequest $request,
        CreateGroup $action,
        CreateGroupUser $groupUser
    ): JsonResponse {
        $group = $action->handle($request->validated());

        $groupUser->handle($group);

        return response()->json(new GroupResource($group), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group, showGroup $action, GetPhotosInGroup $actionPhotos): AnonymousResourceCollection|Response
    {
        $result = $action->handle($group);

        if (request()->wantsJson()) {
            return PostResource::collection($result['posts'] ?? []);
        }

        $postAttachments = $actionPhotos->handle($group);

        return Inertia::render('Group/View', [
            'success' => session('success'),
            'group' => new GroupResource($group->load('currentUserGroup')),
            'users' => GroupUserResource::collection($result['users']),
            'requests' => UserResource::collection($result['requests']),
            'posts' => $result['posts'] ? PostResource::collection($result['posts']) : null,
            'photos' => PostAttachmentResource::collection($postAttachments),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group, UpdateGroup $action): RedirectResponse
    {
        $action->handle($group, $request->validated());

        return back()->with('success', 'Group updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUser(
        DeleteUserRequest $request, Group $group, DeleteUser $action
    ): \Illuminate\Http\Response|RedirectResponse {
        if ($request->user()?->can('change-role', $request['user_id'])) {
            return response('You cannot remove yourself from the group.', 403);
        }
        $action->handle($group, $request->validated());

        return back();
    }

    public function updateImages(
        MediaRequest $request,
        #[CurrentUser] User $user,
        CreateCover $actionCover,
        CreateThumbnail $actionThumbnail
    ): RedirectResponse {
        $success = match (true) {
            $actionCover->handle($user, $request->validated()) => 'Your cover image has been updated successfully.',
            $actionThumbnail->handle($user, $request->validated()) => 'Your thumbnail image has been updated successfully.',
            default => 'Your thumbnail image was not updated.',
        };

        return back()->with('success', $success);
    }

    public function invite(InviteUserRequest $request, Group $group, CreateInviteUser $action): RedirectResponse
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

    public function AcceptInvitation(
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

    public function join(Group $group, JoinToGroup $action): RedirectResponse
    {
        $action->handle($group);

        return back()->with('success', 'Your request has been accepted. you will be notified once you will be approved.');
    }

    public function approveRequest(ApprovedRequest $request, Group $group, FirstApprovedRequests $action): RedirectResponse
    {
        $result = $action->handle($group, $request->validated());

        $message = $result['approved']
            ? "User \"{$result['user']}\" was approved"
            : "User \"{$result['user']}\" was rejected";

        return back()->with('success', $message);
    }

    public function changeRole(
        ChangeRoleRequest $request,
        Group $group,
        ChangeRole $action
    ): \Illuminate\Http\Response|RedirectResponse {
        if ($request->user()?->can('change-role', $request['user_id'])) {
            return response('You cannot change the role of yourself', 403);
        }

        $action->handle($group, $request->validated());

        return back();
    }
}
