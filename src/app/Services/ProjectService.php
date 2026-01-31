<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

class ProjectService
{
    public function __construct(private ProjectRepository $repo) {}

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function byCompany(int $companyId)
    {
        return $this->repo->byCompany($companyId);
    }

    public function show(int $id)
    {
        return $this->repo->find($id);
    }
}
