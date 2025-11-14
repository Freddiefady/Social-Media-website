<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\PostAttachmentObserver;
use Database\Factories\PostAttachmentFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $post_id
 * @property int $created_by
 * @property string $name
 * @property string $path
 * @property string $mime
 * @property int $size
 * @property-read Post $post
 */
#[ObservedBy(PostAttachmentObserver::class)]
final class PostAttachment extends Model
{
    /** @use HasFactory<PostAttachmentFactory> */
    use HasFactory;

    public const null UPDATED_AT = null;

    protected $fillable = [
        'post_id', 'created_by', 'name', 'path', 'mime', 'size',
    ];

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
