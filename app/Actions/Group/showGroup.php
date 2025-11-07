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

    public function handle(Group $group): array
    {
        // Check if current user is an approved member
        if (! $this->membershipService->isApprovedMember($group, auth()->id())) {
            return $this->emptyResponse();
        }

        $posts = $this->query->builder()
            ->where('group_id', $group->id)
            ->paginate(10);

        return [
            'requests' => $group->pendingUsers()->oldest('name')->get(),
            'users' => $group->approvedUsers()->oldest('name')->get(),
            'posts' => $posts,
        ];
    }

    private function emptyResponse(): array
    {
        return [
            'users' => collect(),
            'requests' => collect(),
            'posts' => null,
        ];
    }
}
