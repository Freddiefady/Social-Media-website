<?php

declare(strict_types=1);

namespace App\Actions\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class CreateCover
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(Model $model, array $data): bool
    {
        $file = $data['cover'] ?? null;

        if (! $file instanceof UploadedFile) {
            return false;
        }

        // Delete old cover if exists
        if (isset($model->cover_path) && is_string($model->cover_path)) {
            Storage::disk('public')->delete($model->cover_path);
        }

        // Store new cover
        $key = $model->getKey();
        if (! is_string($key) && ! is_int($key)) {
            return false;
        }

        $path = $file->store('covers/'.$key, 'public');

        $model->update(['cover_path' => $path]);

        return true;
    }
}
