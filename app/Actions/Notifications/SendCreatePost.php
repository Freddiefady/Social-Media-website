<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostCreated;
use Illuminate\Support\Facades\Notification;

final class SendCreatePost
{
    public function handle(Post $post, User $user, ?Group $group = null): void
    {
        if ($group instanceof Group) {
            $users = $group->approvedUsers()->whereKeyNot(auth()->id())->get();
            Notification::send($users, new PostCreated($post, $user, $group));
        }
        Notification::send($user->followers, new PostCreated($post, $user));
    }
}
