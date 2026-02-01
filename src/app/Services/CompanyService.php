<?php

namespace App\Services;

use App\Repositories\CompanyRepository;

class CompanyService
{
    public function __construct(private CompanyRepository $repo) {}

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function list()
    {
        return $this->repo->all();
    }

    public function show(int $id)
    {
        return $this->repo->find($id);
    }
}

