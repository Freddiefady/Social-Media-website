<?php

declare(strict_types=1);

namespace App\Actions\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

final class CreateThumbnail
{
    public function handle(Model $model, $data): bool
    {
        if (! $data['avatar']) {
            return false;
        }

        if (! empty($model->avatar_path)) {
            // Delete the old avatar image if it exists
            Storage::disk('public')->delete($model->avatar_path);
        }

        $path = $data['avatar']->store('avatars/'.$model->id, 'public');
        $model->update(['avatar_path' => $path]);

        return true;
    }
}
