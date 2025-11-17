<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @property-read bool $auto_approval
 * @property-read int $user_id
 * @property-read int $deleted_by
 * @property-read Carbon $deleted_at
 * @property-read Carbon $updated_at
 * @property-read Carbon $created_at
 * @property-read HasOne<GroupUser, Group> $currentUserGroup
 * @property-read int $pinned_post_id
 */
final class GroupResource extends JsonResource
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
            'status' => empty($this->currentUserGroup->status) ? null : $this->currentUserGroup->status,
            'role' => empty($this->currentUserGroup->role) ? null : $this->currentUserGroup->role,
            'thumbnail_url' => $this->thumbnail_path ? Storage::url($this->thumbnail_path) : '/img/no_image.png',
            'cover_url' => $this->cover_path ? Storage::url($this->cover_path) : null,
            'auto_approval' => $this->auto_approval,
            'pinned' => $this->pinned_post_id,
            'about' => $this->about,
            'description' => Str::words(strip_tags($this->about), 10),
            'user_id' => $this->user_id,
            //            'deleted_at' => $this->deleted_at,
            //            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
