<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Actions\PostAttachment\DeleteAttachments;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB;

final readonly class UpdatePost
{
    public function __construct(private DeleteAttachments $action) {}

    /**
     * @throws
     */
    public function handle(
        Post $post,
        array $data,
        array $deleteIds,
    ): void {
        DB::beginTransaction();
        try {
            $post->update($data);

            $this->action->handle($post, $deleteIds);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
