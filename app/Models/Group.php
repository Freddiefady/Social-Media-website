<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GroupUserStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\This;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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
 */
final class Group extends Model
{
    use SoftDeletes, HasSlug;

    protected $fillable = [
        'name', 'slug', 'about', 'cover_path', 'thumbnail_path', 'user_id', 'auto_approval', 'deleted_by', 'deleted_at',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * All users in the group (with pivot data)
     *
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users')
            ->withPivot(['role', 'status', 'token', 'token_expire_date', 'token_used', 'created_by'])
            ->withTimestamps();
    }

    /**
     * Only approved users
     *
     * @return BelongsToMany<User, This>
     */
    public function approvedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users')
            ->withPivot(['role', 'status', 'created_by'])
            ->wherePivot('status', GroupUserStatusEnum::APPROVED)
            ->withTimestamps();
    }

    /**
     * Pending users
     *
     * @return BelongsToMany<User, $this>
     */
    public function pendingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users')
            ->withPivot(['role', 'status', 'created_by'])
            ->wherePivot('status', GroupUserStatusEnum::PENDING)
            ->withTimestamps();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
