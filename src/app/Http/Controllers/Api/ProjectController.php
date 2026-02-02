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
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $project = $this->service->create($data);

        return response()->json([
            'data' => $project
        ], 201); // 201 Created
    }

    public function index(Request $request)
    {
        $companyId = $request->query('company_id');

        $projects = $this->service->list($companyId);

        return response()->json([
            'data' => $projects
        ]);
    }

    public function show($id)
    {
        $project = $this->service->find($id);

        return response()->json([
            'data' => $project
        ]);
    }
}
