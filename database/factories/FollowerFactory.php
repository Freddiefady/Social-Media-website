<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Follower;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<Follower>
 */
final class FollowerFactory extends Factory
{
    protected $model = Follower::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'follower_id' => $this->faker->randomNumber(),
            'created_at' => Date::now(),
        ];
    }
}
