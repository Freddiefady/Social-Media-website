<?php

declare(strict_types=1);

namespace App\Actions\Followers;

use App\Actions\Notifications\SendFollowerUser;
use App\Models\User;
use App\Services\FollowerService;

final readonly class ToggleFollowerUser
{
    public function __construct(
        private FollowerService $followerService,
        private SendFollowerUser $sendFollowerUser,
    ) {}

    /**
     * Create a new class instance.
     */
    public function handle(User $user): bool
    {
        $isNowFollowing = $this->followerService->toggle($user);
        $this->sendFollowerUser->handle($user, $isNowFollowing);

        return $isNowFollowing;
    }
}
