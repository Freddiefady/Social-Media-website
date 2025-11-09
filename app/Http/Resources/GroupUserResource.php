<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $avatar_path
 * @property Pivot|null $pivot
 */
final class GroupUserResource extends JsonResource
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
            'username' => $this->username,
            'avatar_url' => Storage::url($this->avatar_path),
            'role' => isset($this->pivot->role),
            'status' => isset($this->pivot->status),
            'group_id' => isset($this->pivot->group_id),
        ];
    }
}
