<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GroupUserRoleEnum;
use App\Enums\GroupUserStatusEnum;
use Database\Factories\GroupUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $role
 * @property-read int $user_id
 * @property-read int $group_id
 * @property-read string $status
 * @property-read string $token
 * @property-read string $token_expire_date
 * @property-read string $token_used
 * @property-read int $created_by
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read User $user
 * @property-read Group $group
 * @property-read User $creator
 */
final class GroupUser extends Model
{
    /** @use HasFactory<GroupUserFactory> */
    use HasFactory;

    public const null UPDATED_AT = null;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'role', 'user_id', 'group_id', 'status', 'token', 'token_expire_date', 'token_used', 'created_by',
    ];

    /**
     * @return array<string, string>
     */
    protected $casts = [
        'role' => GroupUserRoleEnum::class,
        'status' => GroupUserStatusEnum::class,
        'token' => 'hashed',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Group, $this>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
