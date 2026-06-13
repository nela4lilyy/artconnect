<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@artconnect.com'],
            [
                'name'     => 'Admin ArtConnect',
                'email'    => 'admin@artconnect.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );
    }
}
