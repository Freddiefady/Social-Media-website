<?php

namespace App\Http\Requests\Group;

use App\Enums\GroupUserRoleEnum;
use App\Models\Group;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[RouteParameter('group')] Group $group,
    ): bool
    {
        return request()->user()->can('view-any', $group);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'role' => ['required', Rule::enum(GroupUserRoleEnum::class)],
        ];
    }
}
