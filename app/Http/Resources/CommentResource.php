<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin Comment
 * @property int $reactions_count
 * @property Collection<int, Comment> $comments
 * @property int $comments_count
 */
final class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'num_of_reactions' => $this->reactions_count,
            'current_user_has_reaction' => $this->reactions->isNotEmpty(),
            'comments' => CommentResource::collection($this->comments),
            'num_of_comments' => $this->comments_count,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'username' => $this->user->username,
                'avatar_url' => Storage::url($this->user->avatar_path),
            ],
        ];
    }
}
