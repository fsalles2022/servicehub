<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin ServiceHub',
            'email' => 'admin@servicehub.com',
            'password' => bcrypt('admin12345')  // senha padrão
        ]);

        $this->call([
            CompanySeeder::class,
            ProjectSeeder::class,
            UserSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
