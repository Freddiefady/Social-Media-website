<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Auth\Access\Response;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property string $about
 */
final class UpdateGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[RouteParameter('group')] Group $group
    ): Response {
        return Gate::authorize('view-any', $group);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'auto_approval' => ['required', 'boolean'],
            'about' => ['required', 'string'],
            'user_id' => ['exists:users,id'],
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'about' => nl2br($this->about),
        ]);
    }
}
