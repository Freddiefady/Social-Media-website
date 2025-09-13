<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Storage;

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
    public function updateImages(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'avatar' => 'nullable|image|max:2048',
            'cover' => 'nullable|image|max:2048',
        ]);

        $user = $request->user();

        $success = '';
        $avatar = $data['avatar'] ?? null;
        /** @var \Illuminate\Http\UploadedFile $cover */
        $cover = $data['cover'] ?? null;

        if ($cover) {
            if ($user->cover_path) {
                // Delete the old cover image if it exists
                Storage::disk('public')->delete($user->cover_path);
            }
            $path = $cover->store('avatars/'.$user->id, 'public');
            $user->update(['cover_path' => $path]);
            $success = 'Your cover image has been updated successfully.';
        }

        if ($avatar) {
            if ($user->avatar_path) {
                // Delete the old avatar image if it exists
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $avatar->store('avatars/'.$user->id, 'public');
            $user->update(['avatar_path' => $path]);
            $success = 'Your avatar image has been updated successfully.';
        }

        return back()->with('success', $success);
    }
}
