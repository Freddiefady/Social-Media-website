<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Media\CreateCover;
use App\Actions\Media\CreateThumbnail;
use App\Actions\PostAttachment\GetPhotos;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\PostAttachment\PostAttachmentResource;
use App\Http\Resources\Posts\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Queries\PostRelatedReactionAndComments;
use App\Services\FollowerService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use function request;

final class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(
        User $user,
        FollowerService $service,
        PostRelatedReactionAndComments $query,
        GetPhotos $getPhotos
    ): AnonymousResourceCollection|Response {
        $posts = PostResource::collection($query->builder()
            ->where('user_id', $user->id)
            ->paginate(10)
        );

        if (request()->wantsJson()) {
            return $posts;
        }

        $photos = $getPhotos->handle($user);

        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => true,
            'status' => session('status'),
            'success' => session('success'),
            'user' => new UserResource($user),
            'isCurrentUserFollower' => $service->isFollowing($user),
            'followerCount' => $service->followersCount($user),
            'followers' => UserResource::collection($user->followers()->get()),
            'followings' => UserResource::collection($user->following()->get()),
            'posts' => $posts,
            'photos' => PostAttachmentResource::collection($photos),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()?->fill($request->validated());

        if ($request->user()?->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()?->save();

        return to_route('profile', $request->user())->with('success', 'Your profile details were updated.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user?->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's avatar and cover images.
     */
    public function updateImages(
        MediaRequest $request,
        #[CurrentUser] User $user,
        CreateCover $actionCover,
        CreateThumbnail $actionThumbnail
    ): RedirectResponse {
        $success = match (true) {
            $actionCover->handle($user, $request->validated()) => 'Your cover image has been updated successfully.',
            $actionThumbnail->handle($user, $request->validated()) => 'Your avatar image has been updated successfully.',
            default => 'Your thumbnail image was not updated.',
        };

        return back()->with('success', $success);
    }
}
