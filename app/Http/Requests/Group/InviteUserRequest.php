<?php

declare(strict_types=1);

namespace App\Http\Requests\Group;

use App\Enums\GroupUserStatusEnum;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use App\Rules\ExistsInUsernameOrEmail;
use Closure;
use Illuminate\Auth\Access\Response;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;

final class InviteUserRequest extends FormRequest
{
    private ?GroupUser $existingGroupUser = null;

    private ExistsInUsernameOrEmail $inUsernameOrEmail;

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
        $this->inUsernameOrEmail = new ExistsInUsernameOrEmail();

        return [
            'email' => ['required', $this->inUsernameOrEmail],
        ];
    }

    /**
     * Optional: Check if user is already in the group
     *
     * @return array<Closure>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $user = $this->inUsernameOrEmail->user;

                /** @var Group $groupId */
                $groupId = $this->route('group');

                if ($user && $groupId) {
                    $this->existingGroupUser = GroupUser::query()
                        ->where('group_id', $groupId->id)
                        ->where('user_id', $user->id)
                        ->whereStatus(GroupUserStatusEnum::APPROVED->value)
                        ->firstOrFail();

                    if ($this->existingGroupUser instanceof GroupUser) {
                        $validator->errors()->add('email', 'This user is already a member of the group.');
                    }
                }
            },
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
