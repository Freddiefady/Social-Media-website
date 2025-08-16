<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostAttachment extends Model
{
    const UPDATED_AT = null;

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
        static::deleted(function (self $model) {
            Storage::disk('public')->delete($model->path);
        });
    }
}
