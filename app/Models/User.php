<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $username
 * @property-read string $email
 * @property-read string|null $cover_path
 * @property-read string|null $avatar_path
 * @property-read string $password
 * @property-read int $pinned_post_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Collection<int, Post> $posts
 * @property-read Collection<int, Comment> $comments
 * @property-read Collection<int, Group> $groups
 * @property-read Collection<int, Group> $approvedGroups
 * @property-read Collection<int, self> $followers
 * @property-read Collection<int, self> $following
 */
final class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, hasSlug, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'cover_path',
        'avatar_path',
        'password',
        'pinned_post_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Only approved groups
     *
     * @return BelongsToMany<Group, $this>
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_users')
            ->withPivot(['role', 'status']);
    }

    /**
     * Users that this user follows
     *
     * @return BelongsToMany<self, $this>
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * Users that follow this user
     *
     * @return BelongsToMany<self, $this>
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'follower_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('username')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
