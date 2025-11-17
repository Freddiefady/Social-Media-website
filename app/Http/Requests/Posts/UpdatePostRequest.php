<?php

declare(strict_types=1);

namespace App\Http\Requests\Posts;

use App\Models\Post;

final class UpdatePostRequest extends StorePostRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): true
    {
        /** @var Post $post */
        $post = $this->route('post');

        abort_if(auth()->id() !== $post->user_id, 403, 'Unauthorized');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['group_id']);

        return array_merge($rules, [
            'deleted_file_ids' => 'array',
            'deleted_file_ids.*' => 'numeric',
        ]);
    }
}
