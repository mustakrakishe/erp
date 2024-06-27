<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'login'       => 'root',
            'password'    => 'password',
            'role'        => User::ROLE_ROOT,
            'superior_id' => null,
        ]);
    }
}
