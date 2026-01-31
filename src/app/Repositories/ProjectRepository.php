<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function create(array $data)
    {
        return Project::create($data);
    }

    public function byCompany(int $companyId)
    {
        return Project::where('company_id', $companyId)
            ->with('tickets')
            ->get();
    }

    public function find(int $id)
    {
        return Project::with('tickets')->findOrFail($id);
    }
}
