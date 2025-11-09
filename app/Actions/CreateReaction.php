<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Reaction;
use Illuminate\Database\Eloquent\Model;

final readonly class CreateReaction
{
    public function handle(Model $model, string $type): bool
    {
        $reaction = Reaction::whereActionableIdAndActionableType($model->getKey(), $model->getMorphClass())
            ->whereUserId(auth()->id())
            ->first();

        if ($reaction) {
            $reaction->delete();

            return false;
        }

        Reaction::query()->create([
            'actionable_id' => $model->getKey(),
            'actionable_type' => $model->getMorphClass(),
            'user_id' => auth()->id(),
            'type' => $type,
        ]);

        return true;
    }
}
