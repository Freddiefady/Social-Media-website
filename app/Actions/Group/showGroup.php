<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Models\Group;
use App\Queries\PostRelatedReactionAndComments;
use App\Services\GroupMembershipService;

final readonly class showGroup
{
    public function __construct(
        private PostRelatedReactionAndComments $query,
        private GroupMembershipService $membershipService
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function handle(Group $group): array
    {
        $userId = auth()->id();

        // Check if current user is an approved member
        $this->membershipService->isApprovedMember($group, (int) $userId);

        $posts = $this->query->builder(latest: false)
            ->where('group_id', $group->id)
            ->leftJoin('groups AS g', 'g.pinned_post_id', 'posts.id')
            ->orderByDesc('g.pinned_post_id')
            ->paginate(10);

        return [
            'requests' => $group->pendingUsers()->oldest('name')->get(),
            'users' => $group->approvedUsers()->oldest('name')->get(),
            'posts' => $posts,
        ];
    }
}
