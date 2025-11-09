<?php

declare(strict_types=1);

namespace App\Http\Resources\PostAttachment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $post_id
 * @property int $created_by
 * @property string $name
 * @property string $path
 * @property string $mime
 * @property string $size
 * @property mixed $created_at
 * @property mixed $updated_at
 */
final class PostAttachmentResource extends JsonResource
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
