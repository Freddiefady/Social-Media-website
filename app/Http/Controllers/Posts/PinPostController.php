<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Actions\Posts\PostPinGroup;
use App\Actions\UserPinPost;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

final class PinPostController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        Request $request,
        Post $post,
        PostPinGroup $postPinAction,
        UserPinPost $userPinAction
    ): RedirectResponse {

        $pinned = $request->boolean('forGroup')
            ? $postPinAction->handle($post)
            : $userPinAction->handle($post);

        return back()->with(
            'success',
            'Post was successfully '.($pinned ? 'pinned' : 'unpinned')
        );
    }
}
