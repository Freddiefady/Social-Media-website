<?php

namespace App\Http\Resources\Posts;

use App\Http\Resources\PostAttachment\PostAttachmentResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'current_user_has_reaction' => $this->reactions->isNotEmpty(),
        ];
    }
}
