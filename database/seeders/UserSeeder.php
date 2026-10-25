<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('app.seed_admin.email');
        $password = config('app.seed_admin.password');
        $name = config('app.seed_admin.name');

        if (! $email || ! $password) {
            if (! app()->environment('local', 'testing')) {
                return;
            }

            $email = 'test@example.com';
            $password = 'password';
            $name = 'Test User';
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name ?: 'Administrator',
                'password' => $password,
            ],
        );
    }
}
