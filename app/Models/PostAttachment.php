<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\PostAttachmentObserver;
use Database\Factories\PostAttachmentFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(PostAttachmentObserver::class)]
final class PostAttachment extends Model
{
    /** @use HasFactory<PostAttachmentFactory> */
    use HasFactory;

    public const null UPDATED_AT = null;

    protected $fillable = [
        'post_id',
        'created_by',
        'name',
        'path',
        'mime',
        'size',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
