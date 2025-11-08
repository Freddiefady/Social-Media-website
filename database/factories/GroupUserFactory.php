<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GroupUserFactory extends Factory
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
            'created_at' => Carbon::now(),

            'group_id' => Group::factory(),
            'user_id' => User::factory(),
            'created_by' => User::factory(),
        ];
    }
}
