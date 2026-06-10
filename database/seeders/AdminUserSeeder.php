<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@diginiaga.local'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'operator@diginiaga.local'],
            [
                'name' => 'Operator',
                'password' => 'password',
                'role' => 'operator',
                'email_verified_at' => now(),
            ]
        );
    }
}
