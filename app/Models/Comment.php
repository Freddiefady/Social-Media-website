<?php

declare(strict_types=1);

namespace App\Models;

use App\Policies\CommentPolicy;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $comment
 * @property-read int $post_id
 * @property-read int $user_id
 * @property-read int $parent_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read User $user
 * @property-read Post $post
 * @property-read Collection<int, Reaction> $reactions
 */
#[UsePolicy(CommentPolicy::class)]
final class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use HasFactory;

    public int $numOfComments = 0;

    public array $childComments = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['comment', 'post_id', 'user_id', 'parent_id'];

    /**
     * @return BelongsTo<Post, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return MorphMany<Reaction, $this>
     */
    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'actionable');
    }

    /**
     * @return HasMany<self, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
