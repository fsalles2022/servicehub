<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

class ProjectService
{
    protected $repo;

    public function __construct(ProjectRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function list($companyId = null)
    {
        return $this->repo->all($companyId);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }
}
