<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $about
 * @property-read string $slug
 * @property-read string $cover_path
 * @property-read string $thumbnail_path
 * @property-read boolean $auto_approval
 * @property-read int $user_id
 * @property-read int $deleted_by
 * @property-read Carbon $deleted_at
 * @property-read Carbon $updated_at
 * @property-read Carbon $created_at
 * @property string $status
 * @property string $role
 * @property mixed $pivot
 */
class GroupResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->whenPivotLoaded('group_users', function () {
                return $this->pivot?->status;
            }, 'approved'),
            'role' => $this->whenPivotLoaded('group_users', function () {
                return $this->pivot?->role;
            }, 'admin'),
            'thumbnail_url' => $this->thumbnail_path ? Storage::url($this->thumbnail_path) : '/img/no_image.png',
            'cover_url' => $this->cover_path ? Storage::url($this->cover_path) : null,
            'auto_approval' => $this->auto_approval,
            'about' => $this->about,
            'description' => Str::words($this->about, 10),
            'user_id' => $this->user_id,
//            'deleted_at' => $this->deleted_at,
//            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
