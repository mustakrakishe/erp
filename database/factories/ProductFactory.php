<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => fake()->unique()->word(),
            'description' => fake()->sentence(),
            'price'       => fake()->randomFloat(2, 1, 100),
            'owner_id'    => User::factory()->state(['role' => User::ROLE_BUYER])->for(
                                User::factory()->state(['role' => User::ROLE_TEAMLEAD])->for(
                                    User::factory()->state(['role' => User::ROLE_ADMIN])->for(
                                        User::firstWhere('role', User::ROLE_ROOT),
                                        'superior'
                                    ),
                                    'superior'
                                ),
                                'superior'
                            ),
        ];
    }
}
