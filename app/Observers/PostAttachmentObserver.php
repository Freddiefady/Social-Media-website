<?php

namespace App\Observers;

use App\Models\PostAttachment;
use Illuminate\Support\Facades\Storage;

class PostAttachmentObserver
{
    /**
     * Handle the PostAttachment "deleted" event.
     */
    public function deleted(PostAttachment $postAttachment): void
    {
        Storage::disk('public')->delete($postAttachment->path);
    }
}
