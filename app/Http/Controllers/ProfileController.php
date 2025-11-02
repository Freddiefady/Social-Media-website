<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Media\CreateCover;
use App\Actions\Media\CreateThumbnail;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

final class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(User $user): Response
    {
        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'success' => session('success'),
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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

        $user->delete();

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
