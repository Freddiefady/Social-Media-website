<?php

declare(strict_types=1);

namespace App\Actions\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

final class CreateCover
{
    public function handle(Model $model, $data): bool
    {
        if (! $data['cover']) {
            return false;
        }

        if (! empty($model->cover_path)) {
            // Delete the old cover image if it exists
            Storage::disk('public')->delete($model->cover_path);
        }

        $path = $data['cover']->store('avatars/'.$model->id, 'public');
        $model->update(['cover_path' => $path]);

        return true;
    }
}
