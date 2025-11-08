<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Reaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<Reaction>
 */
final class ReactionFactory extends Factory
{
    protected $model = Reaction::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'created_at' => Date::now(),
            'actionable_id' => $this->faker->randomNumber(),
            'actionable_type' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
