<?php

// database/seeders/CompanySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'name' => 'Acme Corp',
            'email' => 'contato@acme.com',
            'phone' => '11999999999'
        ]);

        Company::create([
            'name' => 'Globex Ltd',
            'email' => 'contato@globex.com',
            'phone' => '11988888888'
        ]);
    }
}
