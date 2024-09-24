<?php

namespace Database\Seeders;

use App\Models\User; // Use o seu modelo User, caso esteja em outro namespace, ajuste.
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('senha'), // Defina a senha aqui
        ]);
    }
}
