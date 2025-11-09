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
        $file = $data['avatar'] ?? null;

        if (! $file instanceof UploadedFile) {
            return false;
        }

        if (isset($model->avatar_path) && is_string($model->avatar_path)) {
            // Delete the old avatar image if it exists
            Storage::disk('public')->delete($model->avatar_path);
        }
        // Store new cover
        $key = $model->getKey();
        if (! is_string($key) && ! is_int($key)) {
            return false;
        }

        $path = $file->store('avatars/'.$key, 'public');
        $model->update(['avatar_path' => $path]);

        return true;
    }
}
