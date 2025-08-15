<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
    CONST UPDATED_AT = null;

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
}
