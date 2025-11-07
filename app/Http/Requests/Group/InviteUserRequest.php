<?php

namespace App\Http\Requests\Group;

use App\Enums\GroupUserStatusEnum;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use App\Rules\ExistsInUsernameOrEmail;
use Illuminate\Auth\Access\Response;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;

class InviteUserRequest extends FormRequest
{
    private ExistsInUsernameOrEmail $inUsernameOrEmail;

    protected ?GroupUser $existingGroupUser = null;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $this->inUsernameOrEmail = new ExistsInUsernameOrEmail();

        return [
            'email' => ['required', $this->inUsernameOrEmail],
        ];
    }

    /**
     * Optional: Check if user is already in the group
     *
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $user = $this->getValidatedUser();
                $groupId = $this->route('group')?->id;
                if ($user && $groupId) {
                    $this->existingGroupUser = GroupUser::query()
                        ->where('group_id', $groupId)
                        ->where('user_id', $user->id)
                        ->whereStatus(GroupUserStatusEnum::APPROVED->value)
                        ->first();

                    if ($this->existingGroupUser) {
                        $validator->errors()->add('email', 'This user is already a member of the group.');
                    }
                }
            }
        ];
    }

    public function getValidatedUser(): ?User
    {
        return $this->inUsernameOrEmail->user;
    }

    public function getExistsGroupUser(): ?GroupUser
    {
        return $this->existingGroupUser;
    }
}
