<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

final class PostAttachment extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'post_id',
        'created_by',
        'name',
        'path',
        'mime',
        'size',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::deleted(function (self $model) {
            Storage::disk('public')->delete($model->path);
        });
    }
}
