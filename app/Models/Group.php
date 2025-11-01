<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
