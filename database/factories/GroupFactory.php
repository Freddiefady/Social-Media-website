<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<Group>
 */
final class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'cover_path' => $this->faker->word(),
            'thumbnail_path' => $this->faker->word(),
            'auto_approval' => $this->faker->boolean(),
            'about' => $this->faker->word(),
            'user_id' => User::factory(),
            'deleted_by' => $this->faker->randomNumber(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ];
    }
}
