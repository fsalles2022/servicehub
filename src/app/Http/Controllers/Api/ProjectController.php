<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $service) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'company_id' => 'required|exists:companies,id'
        ]);

        return $this->service->create($data);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }
}
