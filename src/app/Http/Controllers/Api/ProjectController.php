<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        // Validação dos campos obrigatórios
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        return $this->service->create($data);
    }

    public function index(Request $request)
    {
        $companyId = $request->query('company_id');

        return $this->service->list($companyId);
    }

    public function show($id)
    {
        return $this->service->find($id);
    }
}
