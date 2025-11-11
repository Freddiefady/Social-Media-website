<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Models\Group;
use App\Models\Post;
use App\Notifications\PostCreated;
use Illuminate\Support\Facades\Notification;

final class SendCreatePost
{
    public function handle(Group $group, Post $post): void
    {
        $users = $group->approvedUsers()->whereKeyNot(auth()->id())->get();
        Notification::send($users, new PostCreated($post, $group));
    }
}
