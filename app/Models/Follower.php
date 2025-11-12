<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\FollowerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property int $follower_id
 * @property-read User $follower
 */
final class Follower extends Model
{
    /** @use HasFactory<FollowerFactory> */
    use HasFactory;

    public const null UPDATED_AT = null;

    /**
     * @var list<string>
     */
    protected $fillable = ['user_id', 'follower_id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
