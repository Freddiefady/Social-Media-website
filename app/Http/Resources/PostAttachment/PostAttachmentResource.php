<?php

declare(strict_types=1);

namespace App\Http\Resources\PostAttachment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

final class PostAttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'created_by' => $this->created_by,
            'name' => $this->name,
            'url' => Storage::url($this->path),
            'mime' => $this->mime,
            'size' => $this->size,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
