<?php

declare(strict_types=1);

namespace App\Queries;

use App\Enums\GroupUserStatusEnum;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

final readonly class RelevantPostsTimeline
{
    /**
     * Create a new class instance.
     */
    public function __construct(private PostRelatedReactionAndComments $query) {}

    /**
     * @return Builder<Post>
     */
    public function builder(): Builder
    {
        return $this->query->builder()
            ->where(function ($query): void {
                // Posts from users that by the user follows
                $query->whereHas('user.followers', function ($q): void {
                    $q->where('followers.follower_id', auth()->id());
                })
                    // OR posts from groups where user is approved member
                    ->orWhereHas('group.users', function ($q): void {
                        $q->where('group_users.user_id', auth()->id())
                            ->where('group_users.status', GroupUserStatusEnum::APPROVED->value);
                    })
                    // OR posts by themselves
                    ->orWhere('posts.user_id', auth()->id());
            });
    }
}
