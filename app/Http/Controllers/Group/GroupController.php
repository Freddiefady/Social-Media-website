<?php

declare(strict_types=1);

namespace App\Http\Controllers\Group;

use App\Actions\Group\CreateGroup;
use App\Actions\Group\DeleteGroup;
use App\Actions\Group\showGroup;
use App\Actions\Group\UpdateGroup;
use App\Actions\GroupUser\CreateGroupUser;
use App\Actions\Media\CreateCover;
use App\Actions\Media\CreateThumbnail;
use App\Actions\PostAttachment\GetPhotosInGroup;
use App\Http\Controllers\Controller;
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

final class GroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request, CreateGroup $action, CreateGroupUser $groupUser): JsonResponse
    {
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
    public function destroy(Group $group, DeleteGroup $action): RedirectResponse|\Illuminate\Http\Response
    {
        if (request()->user()?->can('is-owner', $group)) {
            return response('You cannot remove the group. You not owner for the group', 403);
        }

        $action->handle($group);

        return to_route('dashboard')->with('success', 'Group deleted');
    }

    public function updateImages(
        MediaRequest $request,
        Group $group,
        CreateCover $actionCover,
        CreateThumbnail $actionThumbnail
    ): RedirectResponse {
        $success = match (true) {
            $actionCover->handle($group, $request->validated()) => 'Your cover image has been updated successfully.',
            $actionThumbnail->handle($group, $request->validated()) => 'Your thumbnail image has been updated successfully.',
            default => 'Your thumbnail image was not updated.',
        };

        return back()->with('success', $success);
    }
}
