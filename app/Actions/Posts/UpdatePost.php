<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Actions\PostAttachment\DeleteAttachments;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class UpdatePost
{
    public function __construct(private DeleteAttachments $action) {}

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string|int, mixed>  $deleteIds
     *
     * @throws Throwable
     */
    public function handle(
        Post $post,
        array $data,
        array $deleteIds,
    ): void {
        DB::transaction(function () use ($post, $data, $deleteIds): void {
            $post->update($data);
            $this->action->handle($post, $deleteIds);
        });
    }
}
