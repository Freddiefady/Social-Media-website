<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupUser>
 */
final class GroupUserFactory extends Factory
{
    protected $model = GroupUser::class;

    public function definition(): array
    {
        return [
            'role' => $this->faker->word(),
            'status' => $this->faker->word(),
            'token' => Str::random(10),
            'token_expire_date' => Str::random(10),
            'token_used' => Str::random(10),
            'created_at' => \Illuminate\Support\Facades\Date::now(),

            'group_id' => Group::factory(),
            'user_id' => User::factory(),
            'created_by' => User::factory(),
        ];
    }
}
