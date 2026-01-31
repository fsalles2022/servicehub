<?php

// database/seeders/ProjectSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Company;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Company::all() as $company) {
            Project::create([
                'company_id' => $company->id,
                'name' => $company->name . ' - Website',
                'description' => 'Projeto principal de ' . $company->name
            ]);

            Project::create([
                'company_id' => $company->id,
                'name' => $company->name . ' - App Mobile',
                'description' => 'Aplicativo mobile de ' . $company->name
            ]);
        }
    }
}
