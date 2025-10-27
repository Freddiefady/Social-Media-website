<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\PostAttachment;
use Illuminate\Support\Facades\Storage;

final class PostAttachmentController extends Controller
{
    /**
     * Download the specified attachment.
     */
    public function __invoke(PostAttachment $attachment)
    {
        // TODO - check if user has permission to download this attachment
        return response()->download(Storage::disk('public')->path($attachment->path), $attachment->name);
    }
}
