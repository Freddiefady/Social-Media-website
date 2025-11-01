<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\GroupUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin GroupUser */
final class GroupUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'role' => $this->role,
            'user_id' => $this->user_id,
            'group_id' => $this->group_id,
            'status' => $this->status,
            'token' => $this->token,
            'token_expire_date' => $this->token_expire_date,
            'token_used' => $this->token_used,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
