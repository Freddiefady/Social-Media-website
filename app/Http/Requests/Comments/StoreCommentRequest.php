<?php

declare(strict_types=1);

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;

final class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment' => 'required|string',
            'post_id' => 'exists:posts,id',
            'user_id' => 'exists:users,id',
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
