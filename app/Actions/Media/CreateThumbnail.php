<?php

declare(strict_types=1);

namespace App\Actions\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class CreateThumbnail
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(Model $model, array $data): bool
    {
        $key = $model->getKey();
        if (! is_string($key) && ! is_int($key)) {
            return false;
        }

        $processed = false;

        // Handle avatar
        $avatarFile = $data['avatar'] ?? null;
        if ($avatarFile instanceof UploadedFile) {
            if (isset($model->avatar_path) && is_string($model->avatar_path)) {
                // Delete the old avatar image if it exists
                Storage::disk('public')->delete($model->avatar_path);
            }
            $avatarPath = $avatarFile->store('avatars/'.$key, 'public');
            $model->update(['avatar_path' => $avatarPath]);
            $processed = true;
        }

        // Handle thumbnail
        $thumbnailFile = $data['thumbnail'] ?? null;
        if ($thumbnailFile instanceof UploadedFile) {
            if (isset($model->thumbnail_path) && is_string($model->thumbnail_path)) {
                // Delete the old thumbnail image if it exists
                Storage::disk('public')->delete($model->thumbnail_path);
            }
            $thumbnailPath = $thumbnailFile->store('thumbnails/'.$key, 'public');
            $model->update(['thumbnail_path' => $thumbnailPath]);
            $processed = true;
        }

        return $processed;
    }
}
