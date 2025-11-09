<?php

declare(strict_types=1);

namespace App\Http\Requests\Comments;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Comment $comment */
        $comment = $this->route('comment');

        return $comment->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'comment' => ['string', 'max:2000'],
        ];
    }
}
