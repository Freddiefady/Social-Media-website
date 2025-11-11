<?php

declare(strict_types=1);

namespace App\Actions;

use App\Actions\Notifications\SendReactionNotification;
use App\Models\Reaction;
use Illuminate\Database\Eloquent\Model;

final readonly class CreateReaction
{
    public function __construct(private SendReactionNotification $sendReactionOnPost) {}

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

        $this->sendReactionOnPost->handle($model);

        return true;
    }
}
