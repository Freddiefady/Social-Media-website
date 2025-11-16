<?php

declare(strict_types=1);

namespace App\Http\Resources\Posts;

use App\Http\Resources\CommentResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\PostAttachment\PostAttachmentResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\PostAttachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
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
 * @property-read mixed $group
 * @property-read Collection<int, PostAttachment> $attachments
 * @property-read int $reactions_count
 * @property-read int $comments_count
 * @property-read mixed $reactions
 * @property-read Collection<int, Comment> $comments
 * @property Json $preview
 * @property string $preview_url
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
        $reaction = $this->reactions;
        $hasReaction = $reaction instanceof Collection && $reaction->where('user_id', auth()->id())->isNotEmpty()
            ? $reaction
            : false;

        return [
            'id' => $this->id,
            'body' => $this->body,
            'preview' => $this->preview,
            'preview_url' => $this->preview_url,
            'created_at' => $this->created_at->format('y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('y-m-d H:i:s'),
            'user' => new UserResource($this->user),
            'group' => new GroupResource($this->group),
            'attachments' => PostAttachmentResource::collection($this->attachments),
            'num_of_reactions' => $this->reactions_count,
            'num_of_comments' => is_countable($comment) ? count($comment) : 0,
            'current_user_has_reaction' => $hasReaction,
            'comments' => self::convertCommentsIntoTree($comment),
        ];
    }

    /**
     * Convert flat comments into a tree structure
     *
     * @param  Collection<int, Comment>  $comments
     * @return array<int, CommentResource>
     */
    private static function convertCommentsIntoTree(Collection $comments, ?int $parentId = null): array
    {
        $commentTree = [];

        foreach ($comments as $comment) {
            if ($comment->parent_id === $parentId) {
                // find all comment which has parentId as $comment->id
                $children = self::convertCommentsIntoTree($comments, $comment->id);
                $comment->childComments = $children;
                $comment->numOfComments = (int) collect($children)->sum(fn ($child): int => ($child->childComments ? count($child->childComments) : 0)) + count($children);
                $commentTree[] = new CommentResource($comment);
            }
        }

        return $commentTree;
    }
}
