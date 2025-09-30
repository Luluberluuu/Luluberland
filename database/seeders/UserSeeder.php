<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder

{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Luluberlu',
            'email' => 'parrain.luka@gmail.com',
            'password' => Hash::make('Hasko07100/'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Invité',
            'email' => 'invite@test.com',
            'password' => Hash::make('password123456'),
            'role' => 'user',
        ]);
    }
}
