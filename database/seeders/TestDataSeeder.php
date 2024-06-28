<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $root = User::firstWhere('role', User::ROLE_ROOT);

            $admin_1 = User::factory()->create([
                'login'       => 'admin_1',
                'role'        => User::ROLE_ADMIN,
                'superior_id' => $root->id,
            ]);

                $teamlead_1_1 = User::factory()->create([
                    'login'       => 'teamlead_1_1',
                    'role'        => User::ROLE_TEAMLEAD,
                    'superior_id' => $admin_1->id,
                ]);

                    $buyer_1_1_1 = User::factory()->create([
                        'login'       => 'buyer_1_1_1',
                        'role'        => User::ROLE_BUYER,
                        'superior_id' => $teamlead_1_1->id,
                    ]);

                    $buyer_1_1_2 = User::factory()->create([
                        'login'       => 'buyer_1_1_2',
                        'role'        => User::ROLE_BUYER,
                        'superior_id' => $teamlead_1_1->id,
                    ]);

                $teamlead_1_2 = User::factory()->create([
                    'login'       => 'teamlead_1_2',
                    'role'        => User::ROLE_TEAMLEAD,
                    'superior_id' => $admin_1->id,
                ]);

                    $buyer_1_2_1 = User::factory()->create([
                        'login'       => 'buyer_1_2_1',
                        'role'        => User::ROLE_BUYER,
                        'superior_id' => $teamlead_1_2->id,
                    ]);

                    $buyer_1_2_2 = User::factory()->create([
                        'login'       => 'buyer_1_2_2',
                        'role'        => User::ROLE_BUYER,
                        'superior_id' => $teamlead_1_2->id,
                    ]);

            $admin_2 = User::factory()->create([
                'login'       => 'admin_2',
                'role'        => User::ROLE_ADMIN,
                'superior_id' => $root->id,
            ]);

                $teamlead_2_1 = User::factory()->create([
                    'login'       => 'teamlead_2_1',
                    'role'        => User::ROLE_TEAMLEAD,
                    'superior_id' => $admin_2->id,
                ]);

                    $buyer_2_1_1 = User::factory()->create([
                        'login'       => 'buyer_2_1_1',
                        'role'        => User::ROLE_BUYER,
                        'superior_id' => $teamlead_2_1->id,
                    ]);

                    $buyer_2_1_2 = User::factory()->create([
                        'login'       => 'buyer_2_1_2',
                        'role'        => User::ROLE_BUYER,
                        'superior_id' => $teamlead_2_1->id,
                    ]);

                $teamlead_2_2 = User::factory()->create([
                    'login'       => 'teamlead_2_2',
                    'role'        => User::ROLE_TEAMLEAD,
                    'superior_id' => $admin_2->id,
                ]);

                    $buyer_2_2_1 = User::factory()->create([
                        'login'       => 'buyer_2_2_1',
                        'role'        => User::ROLE_BUYER,
                        'superior_id' => $teamlead_2_2->id,
                    ]);

                    $buyer_2_2_2 = User::factory()->create([
                        'login'       => 'buyer_2_2_2',
                        'role'        => User::ROLE_BUYER,
                        'superior_id' => $teamlead_2_2->id,
                    ]);
    }
}
