<?php

declare(strict_types=1);

namespace App\Http\Resources\Posts;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostAttachment\PostAttachmentResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
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
 * @property Collection<int, Comment> $comments
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
        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at->format('y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('y-m-d H:i:s'),
            'user' => new UserResource($this->user),
            'group' => $this->group,
            'attachments' => PostAttachmentResource::collection($this->attachments),
            'num_of_reactions' => $this->reactions_count,
            'num_of_comments' => $this->comments_count,
            'current_user_has_reaction' => $this->reactions->isNotEmpty(),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
