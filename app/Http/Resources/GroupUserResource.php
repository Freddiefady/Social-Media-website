<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\GroupUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin GroupUser
 * @property string $name
 * @property string $username
 * @property string $avatar_path
 * @property mixed $pivot
 */
final class GroupUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'avatar_url' => Storage::url($this->avatar_path),
            'role' => $this->whenPivotLoaded('group_users', $this->pivot->role),
            'status' => $this->whenPivotLoaded('group_users', $this->pivot->status),
            'group_id' => $this->whenPivotLoaded('group_users', $this->pivot->group_id),
        ];
    }
}
