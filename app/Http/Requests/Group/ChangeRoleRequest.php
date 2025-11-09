<?php

declare(strict_types=1);

namespace App\Http\Requests\Group;

use App\Enums\GroupUserRoleEnum;
use App\Models\Group;
use Illuminate\Auth\Access\Response;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

final class ChangeRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[RouteParameter('group')] Group $group,
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
            'user_id' => ['required'],
            'role' => ['required', Rule::enum(GroupUserRoleEnum::class)],
        ];
    }
}
