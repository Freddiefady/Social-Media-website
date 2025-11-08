<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ReactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $actionable_id
 * @property-read string $actionable_type
 * @property-read string $type
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read User $user
 * @property-read self $action
 */
final class Reaction extends Model
{
    /** @use HasFactory<ReactionFactory> */
    use HasFactory;

    public const null UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'actionable_id',
        'actionable_type',
        'type',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent object models (post, comment).
     *
     * @return MorphTo<self, $this>
     */
    public function action(): MorphTo
    {
        return $this->MorphTo();
    }
}
