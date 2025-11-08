<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\PostAttachment;
use Illuminate\Support\Facades\Storage;

final class PostAttachmentObserver
{
    /**
     * Handle the PostAttachment "deleted" event.
     */
    public function deleted(PostAttachment $postAttachment): void
    {
        Storage::disk('public')->delete($postAttachment->path);
    }
}
