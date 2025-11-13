<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $username
 * @property-read string $email
 * @property-read string $email_verified_at
 * @property-read string $cover_path
 * @property-read string $avatar_path
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
final class UserResource extends JsonResource
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
            'cover_url' => $this->cover_path ? Storage::url($this->cover_path) : null,
            'avatar_url' => $this->avatar_path ? Storage::url($this->avatar_path) : asset('img/avatar.png'),
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
