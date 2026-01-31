<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function create(array $data)
    {
        return Company::create($data);
    }

    public function all()
    {
        return Company::with('projects')->get();
    }

    public function find(int $id)
    {
        return Company::with('projects')->findOrFail($id);
    }
}
