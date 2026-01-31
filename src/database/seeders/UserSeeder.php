<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Fabio Salles',
            'email' => 'fabio@test.com',
            'password' => Hash::make('password123')
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'phone' => '11999999999',
            'position' => 'Desenvolvedor Backend'
        ]);

        $user2 = User::create([
            'name' => 'Maria Silva',
            'email' => 'maria@test.com',
            'password' => Hash::make('password123')
        ]);

        UserProfile::create([
            'user_id' => $user2->id,
            'phone' => '11988888888',
            'position' => 'Analista de Sistemas'
        ]);
    }
}
