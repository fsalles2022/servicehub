<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function create(array $data)
    {
        return Project::create($data);
    }

    public function all($companyId = null)
    {
        $query = Project::query();

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        return $query->get();
    }

    public function find($id)
    {
        return Project::with('company')->findOrFail($id);
    }
}
