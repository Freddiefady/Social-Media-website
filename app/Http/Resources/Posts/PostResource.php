<?php

declare(strict_types=1);

namespace App\Http\Resources\Posts;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostAttachment\PostAttachmentResource;
use App\Http\Resources\UserResource;
use App\Models\PostAttachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property mixed $id
 * @property mixed $body
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property mixed $group
 * @property Collection<int, PostAttachment> $attachments
 * @property int $reactions_count
 * @property int $comments_count
 * @property mixed $reactions
 * @property mixed $comments
 */
final class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $comment = $this->comments;

        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at->format('y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('y-m-d H:i:s'),
            'user' => new UserResource($this->user),
            'group' => $this->group,
            'attachments' => PostAttachmentResource::collection($this->attachments),
            'num_of_reactions' => $this->reactions_count,
            'num_of_comments' => count($comment),
            'current_user_has_reaction' => $this->reactions->isNotEmpty(),
            'comments' => self::convertCommentsIntoTree($comment),
        ];
    }

    private function convertCommentsIntoTree($comments, $parentId = null): array
    {
        $commentTree = [];

        foreach ($comments as $comment) {
            if ($comment->parent_id === $parentId) {
                // find all comment which has parentId as $comment->id
                $children = self::convertCommentsIntoTree($comments, $comment->id);
                $comment->childComments = $children;
                $comment->numOfComments = collect($children)->sum('numOfComments') + count($children);
                $commentTree[] = new CommentResource($comment);
            }
        }

        return $commentTree;
    }
}
