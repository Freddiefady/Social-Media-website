<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[RouteParameter('group')] Group $group
    ): true {
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
            'name' => 'required|string|max:255',
            'auto_approval' => 'required|boolean',
            'about' => 'required|string',
            'user_id' => 'exists:users,id',
        ];
    }
}
