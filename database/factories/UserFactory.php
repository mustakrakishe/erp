<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'login'       => fake()->unique()->userName(),
            'password'    => 'password',
            'role'        => User::ROLE_TEAMLEAD,
            'superior_id' => User::firstWhere('role', User::ROLE_ROOT),
        ];
    }
}
